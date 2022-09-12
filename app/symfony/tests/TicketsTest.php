<?php

use App\Application\Search\DisplayTechnicians;
use App\Domain\ObjectMother\TicketExample;
use App\Infrastructure\ORM\Doctrine\Repository\TicketRepository;
use App\Infrastructure\ORM\Doctrine\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

final class TicketsTest extends TestCase
{
    private $ticket;
    private $completedTickets = [];
    private $ticketRepository;
    private $userRepository;

    public function setUp(): void
    {
        $this->ticketRepository = Mockery::mock(TicketRepository::class);
        $this->userRepository = Mockery::mock(UserRepository::class);
        $this->ticket = TicketExample::ticket();
    }

    public function test_that_convert_seconds_to_date_works(): void
    {
        $displayTechnicians = new DisplayTechnicians($this->ticketRepository, $this->userRepository);

        $result = $displayTechnicians->secondsToDaysHoursMinutes(352800);
        $this->assertEquals($result, '4d 2h 0m');
    }

    public function test_that_calculate_average_tickets_time_works(): void
    {
        $displayTechnicians = new DisplayTechnicians($this->ticketRepository, $this->userRepository);
        array_push($this->completedTickets,
            TicketExample::completedTicketOne(),
            TicketExample::completedTicketTwo()
        );

        $result = $displayTechnicians->calculateTicketsAverageTime($this->completedTickets);
        $this->assertEquals($result, '12h 0m');
    }

    public function test_that_getTitle_works(): void
    {
        $title = $this->ticket->getTitle();
        $this->assertEquals($title, 'Ticket test');
    }
}