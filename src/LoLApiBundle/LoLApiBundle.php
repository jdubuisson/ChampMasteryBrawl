<?php

namespace LoLApiBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LoLApiBundle extends Bundle
{
    public function getParent()
    {
        return 'DowdowLeagueOfLegendsAPIBundle';
    }
}
