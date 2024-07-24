<?php

namespace App\Entity;

enum Urgency: string
{
   case Low = "Low";
   case Medium = "Medium";
   case High = "High";
   case Critical = "Critical";
}
