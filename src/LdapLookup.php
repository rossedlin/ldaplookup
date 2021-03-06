<?php

namespace Maenbn\LdapLookup;

use Maenbn\LdapLookup\ConnectionInterface as LdapConnection;

class LdapLookup implements LookupInterface
{
    protected $connection;

    public $connected = false;

    protected $config;

    public function __construct(LdapConnection $connection)
    {
        $this->connection = $connection;

        $this->config = $connection->config;
    }

    public function connect()
    {
        $this->connected = $this->connection->connect();

        return $this;
    }

    protected function search($filter)
    {
        return ldap_search($this->connection->connection, $this->config['baseDn'], $filter);
    }

    protected function getEntries($resultsId, $type = null)
    {
        $info = ldap_get_entries($this->connection->connection, $resultsId);

        $entries = [];

        for ($i = 0; $i < $info["count"]; $i ++) {
            $entry = [];

            foreach ($info[$i] as $key => $value) {
                if(isset($value['count'])){
                    unset($value['count']);
                }

                if(is_string($key)){
                    $entry[$key] = $value[0];

                    if (is_array($value) && count($value) > 1) {
                        $entry[$key] = $value;
                    }
                }
            }
            $entries[] = $entry;
        }

        switch ($type) {
            case 'first':
                if (isset($entries[0])) {
                    $entries = $entries[0];
                }
                break;

        }

        return $entries;
    }

    public function getByUid($uid)
    {
        $filter = "uid=" . $uid;

        $entries = $this->runSearch($filter, 'first');

        return $entries;
    }

    public function runSearch($filter, $type = null)
    {
        $this->connect();
        $resultsId = $this->search($filter);
        $entries = $this->getEntries($resultsId, $type);

        return $entries;
    }
}
