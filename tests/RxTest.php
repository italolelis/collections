<?php

namespace Easy\Tests\Collections;

use Easy\Collections\ArrayList;

class RxTest extends CollectionsTestCase
{

    public function peopleProvider()
    {
        $user = new \stdClass();
        $user->name = 'Test';

        $male = new \stdClass();
        $male->name = 'Marc';
        $male->user = $user;
        $male->gender = 'male';
        $male->age = 40;

        $male2 = new \stdClass();
        $male2->name = 'Anderson';
        $male2->user = $user;
        $male2->gender = 'male';
        $male2->age = 19;

        $female = new \stdClass();
        $female->name = 'Ana Martha';
        $female->user = $user;
        $female->gender = 'female';
        $female->age = 21;

        $female2 = new \stdClass();
        $female2->name = 'Daize';
        $female2->gender = 'female';
        $female2->age = 30;

        return [
            [new ArrayList([$male, $male2, $female, $female2])]
        ];
    }

    /**
     *
     * @param $people
     * @dataProvider peopleProvider
     */
    public function testExtractSucess(ArrayList $people)
    {
        $this->assertEquals($people->extract('name')->toArray(), ['Marc', 'Anderson', 'Ana Martha', 'Daize']);
    }

//    public function testUnfold()
//    {
//        $collection = new ArrayList([[1, 2, 3], [4, 5]]);
//        dump($collection->unfold()->toArray());
//        $this->assertEquals($collection->unfold()->toArray(), [1, 2, 3, 4, 5]);
//    }


    /**
     * @param $people
     * @dataProvider peopleProvider
     */
    public function testReject(ArrayList $people)
    {
        $ladies = $people->reject(function ($person) {
            return $person->gender === 'male';
        });

        $this->assertCount(2, $ladies);
    }

    /**
     * @param $people
     * @dataProvider peopleProvider
     */
    public function testSomePeople(ArrayList $people)
    {
        $hasYoungPeople = $people->some(function ($person) {
            return $person->age < 21;
        });

        $this->assertTrue($hasYoungPeople);
    }

    /**
     * @param $people
     * @dataProvider peopleProvider
     */
    public function testMachName($people)
    {
        $commentsFromMark = $people->match(['user.name' => 'Test']);
        $this->assertCount(3, $commentsFromMark);
    }

    public function testReduce()
    {
        $collection = new ArrayList([100, 200]);
        $totalPrice = $collection->reduce(function ($accumulated, $orderLine) {
            return $accumulated + $orderLine;
        }, 0);

        $this->assertEquals(300, $totalPrice);
    }

    /**
     * @param $people
     * @dataProvider peopleProvider
     */
    public function testSample(ArrayList $people)
    {
        $testSubjects = $people->sample(20);
        $this->assertNotEmpty($testSubjects);
    }
}