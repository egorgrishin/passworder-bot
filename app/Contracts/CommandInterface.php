<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface CommandInterface
{
    public function run(Request $request);
}
