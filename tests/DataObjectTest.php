<?php

use App\DataObject;
use App\DataObjectHistory;
use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class DataObjectTest extends TestCase
{

    use DatabaseMigrations; // resets database after each test

    /**
     * /object [POST]
     */
    public function testShouldCreateObject()
    {
        $data = ['testkey' => 'testvalue'];
        $response = $this->post('api/object', $data, []);
        $response->seeStatusCode(201);
        $response->seeInDatabase('data_objects', ['key' => 'testkey', 'value' => 'testvalue']);
    }

    /**
     * /object/{key} [GET]
     */
    public function testShouldReturnObjectValue()
    {
        $object = factory(DataObject::class)->create();
        $response = $this->json('GET', 'api/object/' . $object->key, []);
        $response->seeStatusCode(200);
    }

    /**
     * /object [POST]
     */
    public function testShouldUpdateObject()
    {
        $data = ['testkey' => 'testvalue'];
        $response = $this->post('api/object', $data, []);

        $data = ['testkey' => 'testvalue2'];
        $response = $this->post('api/object', $data, []);

        $response->seeStatusCode(200);
        $response->seeInDatabase('data_objects', ['key' => 'testkey', 'value' => 'testvalue2']);
        $response->seeJsonStructure(['message']);
    }

    /**
     * /object/{key}?timestamp=1601106261 [GET]
     */
    public function testShouldReturnObjectValueBasedOnAdditionalParameter()
    {
        $testDate = Carbon::now()->subDays(10);

        factory(DataObject::class)->create([
            'key' => 'testkey',
            'value' => 'testvalue'
        ]);

        factory(DataObject::class)->create([
            'key' => 'testkey',
            'value' => 'testvalue2',
            'created_at' => $testDate,
            'updated_at' => $testDate
        ]);

        $timestamp = $testDate->timestamp;

        $timestamp = 'asd?timestamp=' . $timestamp;
        $response = $this->get('api/object/' . 'testkey', []);
        $response->seeStatusCode(200);
    }
}
