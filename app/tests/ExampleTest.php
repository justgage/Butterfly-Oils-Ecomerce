<?php

class SessionTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testSession()
	{
        Session::put("SessionTest", 'test1234');

        $val = Session::get("SessionTest", null);

        return $this->assertEquals("test1234", $val);
	}

}
