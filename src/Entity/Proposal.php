<?php

namespace App\Entity;

enum Proposal: string
{
   case Estimate = "Estimate";
   case Bill = "Bill";
}
