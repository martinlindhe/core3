<?php
// TODO use PHPUnit_Extensions_Database_TestCase, see http://phpunit.de/manual/current/en/database.html

/**
 * @group Database
 */
class test2Table extends \Model\DatabaseTable
{
    var $id;
    var $name;
}

/**
 * @group Database
 */
class PdoDriverMysqlTest extends \PHPUnit_Framework_TestCase
{
    private function getConnection()
    {
        $db = new \Database\PdoDriver('mysql');
        $db->setServer('127.0.0.1');
        $db->setDatabase('test');
        $db->setUsername('root');
        $db->setPassword('');
        return $db;
    }

    /**
	 * @expectedException ConnectionFailedException
	 */
    function testConnectionFailure()
    {
        $db = $this->getConnection();
        $db->setPort(60000);

        $db->connect();
    }

    /**
	 * @expectedException AlreadyConnectedException
	 */
    function testConnectionWhenAlreadyConnected()
    {
        $db = $this->getConnection();

        $db->connect();

        $db->connect(); // should raise exception
    }

    function testSelectItem()
    {
        $db = $this->getConnection();

        $this->assertEquals('127.0.0.1', $db->getServer());

        $db->query(
            '
		CREATE TABLE testSelectItem (
			id int(11) unsigned NOT NULL AUTO_INCREMENT,
			name varchar(32) NOT NULL,
			PRIMARY KEY (id)
		)'
        );

        $this->assertEquals(true, $db->isConnected());

        $db->insert('INSERT INTO testSelectItem SET name = :name', array(':name' => 'Pelle'));
        $db->insert('INSERT INTO testSelectItem SET name = :name', array(':name' => 'Kalle'));

        $cnt = $db->selectItem('SELECT COUNT(*) FROM testSelectItem');
        $this->assertEquals(2, $cnt);

        $db->query('DROP TABLE testSelectItem');

        $db->disconnect();
        $this->assertEquals(false, $db->isConnected());
    }

    /**
	 * @expectedException InvalidResultException
	 */
    function testSelectItemMultiRowsResultFailure()
    {
        $db = $this->getConnection();

        $this->assertEquals('127.0.0.1', $db->getServer());

        $db->query('DROP TABLE IF EXISTS testSelectItemMultiRowsResultFailure');

        $db->query(
            '
		CREATE TABLE testSelectItemMultiRowsResultFailure (
			name varchar(32) NOT NULL
		)'
        );

        $this->assertEquals(true, $db->isConnected());

        $db->insert('INSERT INTO testSelectItemMultiRowsResultFailure SET name = :name', array(':name' => 'Pelle'));
        $db->insert('INSERT INTO testSelectItemMultiRowsResultFailure SET name = :name', array(':name' => 'Kalle'));

        $cnt = $db->selectItem('SELECT * FROM testSelectItemMultiRowsResultFailure'); // should raise exception
    }

    /**
	 * @expectedException InvalidResultException
	 */
    function testSelectItemMultipleColumnsFailure()
    {
        $db = $this->getConnection();
        $res = $db->selectItem('SELECT "hej", "HEJ"');
    }

    function testToObject()
    {
        $db = $this->getConnection();

        $db->query(
            '
		CREATE TABLE testToObject (
			id int(11) unsigned NOT NULL AUTO_INCREMENT,
			name varchar(32) NOT NULL,
			PRIMARY KEY (id)
		)'
        );

        $db->insert('INSERT INTO testToObject SET name = :name', array(':name' => 'Lisa'));
        $db->insert('INSERT INTO testToObject SET name = :name', array(':name' => 'Ebba'));
        $db->insert('INSERT INTO testToObject SET name = :name', array(':name' => 'Didrik'));

        $res = $db->selectToObjects('test2Table', 'SELECT * FROM testToObject');

        $this->assertEquals(3, count($res));

        $this->assertInternalType('array', $res);
        $this->assertInstanceOf('test2Table', $res[0]);


        $res = $db->selectToObject(
            'test2Table',
            'SELECT * FROM testToObject WHERE name = :name',
            array(':name' => 'Ebba')
        );

        $chk = new test2Table();
        $chk->id = 2;
        $chk->name = 'Ebba';
        $this->assertEquals($chk, $res);

        $db->query('DROP TABLE testToObject');
    }

    function testSelectRow()
    {
        $db = $this->getConnection();

        $db->query(
            '
		CREATE TABLE testSelectRow (
			id int(11) unsigned NOT NULL AUTO_INCREMENT,
			name varchar(32) NOT NULL,
			PRIMARY KEY (id)
		)'
        );

        $res = $db->select('SELECT * FROM testSelectRow');
        $this->assertSame(array(), $res);

        $db->insert('INSERT INTO testSelectRow SET name = :name', array(':name' => 'Lotta'));

        $res = $db->select('SELECT * FROM testSelectRow');
        $this->assertSame(array( array('id'=>'1','name'=>'Lotta') ), $res);

        $res = $db->selectRow('SELECT * FROM testSelectRow WHERE id = :id', array(':id' => 1));
        $this->assertSame(array('id'=>'1','name'=>'Lotta'), $res);

        $db->query('DROP TABLE testSelectRow');
    }

    /**
	 * @expectedException InvalidResultException
	 */
    function testSelectRowMultipleRowsFailure()
    {
        $db = $this->getConnection();

        $db->query('DROP TABLE IF EXISTS testSelectRowMultipleRowsFailure');

        $db->query(
            '
		CREATE TABLE testSelectRowMultipleRowsFailure (
			id int(11) unsigned NOT NULL AUTO_INCREMENT,
			name varchar(32) NOT NULL,
			PRIMARY KEY (id)
		)'
        );

        $db->insert('INSERT INTO testSelectRowMultipleRowsFailure SET name = :name', array(':name' => 'Lotta'));
        $db->insert('INSERT INTO testSelectRowMultipleRowsFailure SET name = :name', array(':name' => 'Pelle'));

        $res = $db->selectRow('SELECT * FROM testSelectRowMultipleRowsFailure');
    }

    /**
	 * @expectedException InvalidResultException
	 */
    function testSelectRowNoResult()
    {
        $db = $this->getConnection();

        $db->query('DROP TABLE IF EXISTS testSelectRowNoResult');

        $db->query(
            '
		CREATE TABLE testSelectRowNoResult (
			id int(11) unsigned NOT NULL AUTO_INCREMENT,
			name varchar(32) NOT NULL,
			PRIMARY KEY (id)
		)'
        );

        // expected to fail because the id dont exist
        $res = $db->selectRow('SELECT * FROM testSelectRowNoResult WHERE id = :id', array(':id' => 1));
    }

    function testUpdate()
    {
        $db = $this->getConnection();

        $db->query(
            '
		CREATE TABLE testUpdate (
			id int(11) unsigned NOT NULL AUTO_INCREMENT,
			name varchar(32) NOT NULL,
			PRIMARY KEY (id)
		)'
        );

        $db->insert('INSERT INTO testUpdate SET name = :name', array(':name' => 'Pelle'));
        $db->insert('INSERT INTO testUpdate SET name = :name', array(':name' => 'Kalle'));

        $cnt = $db->selectItem('SELECT COUNT(*) FROM testUpdate');
        $this->assertEquals(2, $cnt);

        $db->update(
            'UPDATE testUpdate SET name = :newName WHERE name = :oldName',
            array(':newName' => 'Sven', ':oldName' => 'Kalle')
        );

        $cnt = $db->selectItem('SELECT COUNT(*) FROM testUpdate WHERE name = :name', array(':name' => 'Sven'));
        $this->assertEquals(1, $cnt);

        $db->delete('DELETE FROM testUpdate WHERE name = :name', array(':name' => 'Pelle'));


        $cnt = $db->selectItem('SELECT COUNT(*) FROM testUpdate');
        $this->assertEquals(1, $cnt);


        $db->query('DROP TABLE testUpdate');
    }

    function testSelect1d()
    {
        $db = $this->getConnection();

        $db->query(
            '
		CREATE TABLE testSelect1d (
			name VARCHAR(10) NOT NULL
		)'
        );

        $db->insert(
            'INSERT INTO testSelect1d (name) VALUES (:v1),(:v2),(:v3),(:v4),(:v5)',
            array(':v1' => 'hej', ':v2' => 'svejs', ':v3' => 'tralla', ':v4' => 'lalla', ':v5' => 'lopp')
        );

        $cnt = $db->selectItem('SELECT COUNT(*) FROM testSelect1d');
        $this->assertEquals(5, $cnt);

        $res = $db->select1d('SELECT name FROM testSelect1d');

        $this->assertEquals(array('hej', 'svejs', 'tralla', 'lalla', 'lopp'), $res);

        $db->query('DROP TABLE testSelect1d');
    }

    /**
	 * @expectedException InvalidResultException
	 */
    function testSelect1dFailure()
    {
        $db = $this->getConnection();
        $res = $db->select1d('SELECT "hej", "HEJ"');
    }

    function testSelectMapped()
    {
        $db = $this->getConnection();

        $db->query(
            '
		CREATE TABLE testSelectMapped (
			id int(11) unsigned NOT NULL,
			name VARCHAR(10) NOT NULL
		)'
        );

        $db->insert(
            'INSERT INTO testSelectMapped (id,name) VALUES (:v1a,:v1b),(:v2a,:v2b),(:v3a,:v3b)',
            array(
                ':v1a' => 2, ':v1b' => 'boll',
                ':v2a' => 4, ':v2b' => 'sten',
                ':v3a' => 19, ':v3b' => 'burk'
            )
        );

        $cnt = $db->selectItem('SELECT COUNT(*) FROM testSelectMapped');
        $this->assertEquals(3, $cnt);

        $res = $db->selectMapped('SELECT id, name FROM testSelectMapped');

        $this->assertEquals(array( 2 => 'boll', 4 => 'sten', 19 => 'burk'), $res);

        $db->query('DROP TABLE testSelectMapped');
    }

    /**
	 * @expectedException InvalidResultException
	 */
    function testSelectMappedFailure()
    {
        $db = $this->getConnection();
        $res = $db->selectMapped('SELECT "hej", "HEJ","hwow"');
    }

    /**
	 * @expectedException InvalidArgumentException
	 */
    function testSelectNoQueryFailure()
    {
        $db = $this->getConnection();
        $res = $db->selectMapped('');
    }

    /**
	 * @expectedException InvalidQueryException
	 */
    function testSelectInvalidQueryFailure()
    {
        $db = $this->getConnection();
        $res = $db->selectMapped('SPRING RUNT');
    }

    function testStoredProcedure()
    {
        $db = $this->getConnection();

        // NOTE: the mysql "DELIMITER" command is inplemented client side and is messing with these tests

        $db->query('DROP PROCEDURE IF EXISTS ProcedureTest1');

        $db->query(
            '
		CREATE PROCEDURE ProcedureTest1 (
			IN input VARCHAR(255)
		)

		BEGIN
			SELECT CONCAT(input,"_two");
		END;'
        );

        $res = $db->storedProc(
            'CALL ProcedureTest1(:param)',
            array(':param' => 'tjena')
        );

        // check that result is "tjena_two"
        $this->assertEquals(array( array('CONCAT(input,"_two")' => 'tjena_two')), $res);
    }
}
