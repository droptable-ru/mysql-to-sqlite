<?php

namespace spec\MysqlToSqlite;

use Easychimp\EmailAddressNotSubscribed;
use Easychimp\Support;
use Mailchimp\Mailchimp;
use PhpSpec\ObjectBehavior;
use Easychimp\MailingList;
use Prophecy\Argument;

class OutputFilterSpec extends ObjectBehavior
{
    function it_filters_out_password_warning()
    {
        $warning = '[Warning] Using a password on the command line interface can be insecure.';
        $this->filter($warning)->shouldReturn(null);
    }

    function it_filters_out_memory_output()
    {
        $warning = 'memory';
        $this->filter($warning)->shouldReturn(null);
    }

    function it_provides_output_when_nothing_is_filtered()
    {
        $output = 'It works!';
        $this->filter($output)->shouldReturn($output);
    }
}
