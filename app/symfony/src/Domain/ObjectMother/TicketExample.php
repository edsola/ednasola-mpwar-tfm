<?php

namespace App\Domain\ObjectMother;

use App\Domain\Entity\Priority;
use App\Domain\Entity\Status;
use App\Domain\Entity\Ticket;

class TicketExample
{

    public static function ticket(): Ticket
    {
        $ticket = new Ticket();
        $ticket->setTitle('Ticket test');
        $ticket->setCreatedDate(new \DateTime());
        $ticket->setTechnicianUserId(UserExample::technicianUser());
        $ticket->setPriorityId(new Priority());
        $ticket->setStatusId(new Status());
        $ticket->setAdminUserId(UserExample::adminUser());

        return $ticket;
    }

    public static function completedTicketOne(): Ticket
    {
        $ticket = new Ticket();
        $ticket->setTitle('Completed ticket test');
        $ticket->setCreatedDate(new \DateTime('2022-08-15 16:00:00'));
        $ticket->setCompletedDate(new \DateTime('2022-08-16 16:00:00'));
        $ticket->setTechnicianUserId(UserExample::technicianUser());
        $ticket->setPriorityId(new Priority());
        $ticket->setStatusId(new Status());
        $ticket->setAdminUserId(UserExample::adminUser());

        return $ticket;
    }

    public static function completedTicketTwo(): Ticket
    {
        $ticket = new Ticket();
        $ticket->setTitle('Completed ticket test');
        $ticket->setCreatedDate(new \DateTime('2022-07-01 12:00:00'));
        $ticket->setCompletedDate(new \DateTime('2022-07-01 12:00:00'));
        $ticket->setTechnicianUserId(UserExample::technicianUser());
        $ticket->setPriorityId(new Priority());
        $ticket->setStatusId(new Status());
        $ticket->setAdminUserId(UserExample::adminUser());

        return $ticket;
    }
}