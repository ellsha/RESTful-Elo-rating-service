<?php

namespace App\Elo;

use App\Player;
use PHPUnit\Framework\TestCase;

class EloTests extends TestCase
{
    /**
     * Small elo rating difference between players (200)
     * Few matches count (5)
     */
    public function testSmallRatingIntervalAndFewMatchesCount()
    {
        $player1 = $this->getMockBuilder(Player::class)->setMethods([
            'getEloRating', 'getMatchesCount'
        ])->getMock();
        $player2 = $this->getMockBuilder(Player::class)->setMethods([
            'getEloRating', 'getMatchesCount'
        ])->getMock();

        $player1->method('getEloRating')->will($this->returnValue(1500));
        $player1->method('getMatchesCount')->will($this->returnValue(5));

        $player2->method('getEloRating')->will($this->returnValue(1700));
        $player2->method('getMatchesCount')->will($this->returnValue(5));

        $elo = new Elo();
        $ratings = $elo->win($player1, $player2);

        $this->assertEquals(1530, $ratings[0]);
        $this->assertEquals(1670, $ratings[1]);
    }

    /**
     * Middle elo rating difference between players (600)
     * Few matches count (5)
     */
    public function testMiddleRatingIntervalAndFewMatchesCount()
    {
        $player1 = $this->getMockBuilder(Player::class)->setMethods([
            'getEloRating', 'getMatchesCount'
        ])->getMock();
        $player2 = $this->getMockBuilder(Player::class)->setMethods([
            'getEloRating', 'getMatchesCount'
        ])->getMock();

        $player1->method('getEloRating')->will($this->returnValue(1500));
        $player1->method('getMatchesCount')->will($this->returnValue(5));

        $player2->method('getEloRating')->will($this->returnValue(2100));
        $player2->method('getMatchesCount')->will($this->returnValue(5));


        $elo = new Elo();
        $ratings = $elo->win($player1, $player2);

        $this->assertEquals(1539, $ratings[0]);
        $this->assertEquals(2061, $ratings[1]);
    }

    /**
     * Large elo rating difference between players (1200)
     * Few matches count (5)
     */
    public function testLargeRatingIntervalAndFewMatchesCount()
    {
        $player1 = $this->getMockBuilder(Player::class)->setMethods([
            'getEloRating', 'getMatchesCount'
        ])->getMock();
        $player2 = $this->getMockBuilder(Player::class)->setMethods([
            'getEloRating', 'getMatchesCount'
        ])->getMock();

        $player1->method('getEloRating')->will($this->returnValue(2500));
        $player1->method('getMatchesCount')->will($this->returnValue(5));

        $player2->method('getEloRating')->will($this->returnValue(3700));
        $player2->method('getMatchesCount')->will($this->returnValue(5));


        $elo = new Elo();
        $ratings = $elo->win($player1, $player2);

        $this->assertEquals(2540, $ratings[0]);
        $this->assertEquals(3660, $ratings[1]);
    }

    /**
     * Small elo rating difference between players (200)
     * Many matches count (50)
     */
    public function testSmallRatingIntervalAndManyMatchesCount()
    {
        $player1 = $this->getMockBuilder(Player::class)->setMethods([
            'getEloRating', 'getMatchesCount'
        ])->getMock();
        $player2 = $this->getMockBuilder(Player::class)->setMethods([
            'getEloRating', 'getMatchesCount'
        ])->getMock();

        $player1->method('getEloRating')->will($this->returnValue(1500));
        $player1->method('getMatchesCount')->will($this->returnValue(50));

        $player2->method('getEloRating')->will($this->returnValue(1700));
        $player2->method('getMatchesCount')->will($this->returnValue(50));

        $elo = new Elo();
        $ratings = $elo->win($player1, $player2);

        $this->assertEquals(1515, $ratings[0]);
        $this->assertEquals(1685, $ratings[1]);
    }

    /**
     * Middle elo rating difference between players (600)
     * Many matches count (50)
     */
    public function testMiddleRatingIntervalAndManyMatchesCount()
    {
        $player1 = $this->getMockBuilder(Player::class)->setMethods([
            'getEloRating', 'getMatchesCount'
        ])->getMock();
        $player2 = $this->getMockBuilder(Player::class)->setMethods([
            'getEloRating', 'getMatchesCount'
        ])->getMock();

        $player1->method('getEloRating')->will($this->returnValue(1500));
        $player1->method('getMatchesCount')->will($this->returnValue(50));

        $player2->method('getEloRating')->will($this->returnValue(2100));
        $player2->method('getMatchesCount')->will($this->returnValue(50));

        $elo = new Elo();
        $ratings = $elo->win($player1, $player2);

        $this->assertEquals(1519, $ratings[0]);
        $this->assertEquals(2081, $ratings[1]);
    }

    /**
     * Large elo rating difference between players (1200)
     * Many matches count (5)
     */
    public function testLargeRatingIntervalAndManyMatchesCount()
    {
        $player1 = $this->getMockBuilder(Player::class)->setMethods([
            'getEloRating', 'getMatchesCount'
        ])->getMock();
        $player2 = $this->getMockBuilder(Player::class)->setMethods([
            'getEloRating', 'getMatchesCount'
        ])->getMock();

        $player1->method('getEloRating')->will($this->returnValue(2500));
        $player1->method('getMatchesCount')->will($this->returnValue(50));

        $player2->method('getEloRating')->will($this->returnValue(3700));
        $player2->method('getMatchesCount')->will($this->returnValue(50));

        $elo = new Elo();
        $ratings = $elo->win($player1, $player2);

        $this->assertEquals(2510, $ratings[0]);
        $this->assertEquals(3690, $ratings[1]);
    }
}