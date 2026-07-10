<?php

namespace Ocore\Middleware;

class Guest
{
    public function handle(): void
    {
        if (check_auth()) {
            response()->redirect("/");
        }
    }
}
