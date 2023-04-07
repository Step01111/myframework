<?php
namespace App\Services;

class DB
{
    private $pdo;
    private static $instance;

    private function __construct()
    {
        $op = require ($_SERVER['DOCUMENT_ROOT'].'/app/db-settings.php');
        $db_options = $op['db'];

        $this->pdo = new \PDO(
            'mysql:host='.$db_options['host'].';dbname='.$db_options['dbname'],
            $db_options['user'],
            $db_options['password'],
        );

        $this->pdo->exec('SET NAMES UTF8');
    }

    public static function getInstance(): self
    {
        if (self::$instance == 0) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function query(string $sql, $values, string $className = 'stdClass')
    {
        if ($values) {
            $sth = $this->pdo->prepare($sql);
            $result = $sth->execute($values);
        } else {
            $sth = $this->pdo->query($sql);
        }

        if ($sth) {
            if (preg_match('/^SELECT/', $sql)) {
                return $sth->fetchAll(\PDO::FETCH_CLASS, $className);
            }

            if (preg_match('/^(INSERT|UPDATE|DELETE)/', $sql)) {
                return true;
            }
        }
    }
    
    public function getLastInsertId(): int
    {
        return (int) $this->pdo->lastInsertId();
    }
}
