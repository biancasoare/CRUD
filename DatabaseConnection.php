<?php
/**
 * Created by PhpStorm.
 * User: soarebianca
 * Date: 27/03/2018
 * Time: 14:05
 */


/**
 * Class DatabaseConnection
 */
class DatabaseConnection
{
    /** @var string $host */
    protected $host;

    /** @var string $dbName */
    protected $dbName;

    /** @var string $dbUser */
    protected $dbUser;

    /** @var string $dbPass */
    protected $dbPass;

    /**
     * DatabaseConnection constructor.
     * @param string $host
     * @param string $dbName
     * @param string $dbUser
     * @param string $dbPass
     */
    public function __construct(string $host, string $dbName, string $dbUser, string $dbPass)
    {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPass = $dbPass;
    }

    /**
     * @return PDO
     */
    public function connectToDb()
    {
        return new PDO("mysql:host=".$this->host.";dbname={$this->dbName}", $this->dbUser, $this->dbPass);
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public static function getConnection(array $parameters)
    {
        $connection = new static(
            $parameters['host'],
            $parameters['dbName'],
            $parameters['dbUser'],
            $parameters['dbPass']
        );

        return $connection->connectToDb();
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getDbName(): string
    {
        return $this->dbName;
    }

    /**
     * @param string $dbName
     */
    public function setDbName(string $dbName): void
    {
        $this->dbName = $dbName;
    }

    /**
     * @return string
     */
    public function getDbUser(): string
    {
        return $this->dbUser;
    }

    /**
     * @param string $dbUser
     */
    public function setDbUser(string $dbUser): void
    {
        $this->dbUser = $dbUser;
    }

    /**
     * @return string
     */
    public function getDbPass(): string
    {
        return $this->dbPass;
    }

    /**
     * @param string $dbPass
     */
    public function setDbPass(string $dbPass): void
    {
        $this->dbPass = $dbPass;
    }


}