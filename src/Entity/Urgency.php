<?php

namespace App\Entity;

enum Urgency: string
{
   case Low = "Faible";
   case Medium = "Moyenne";
   case High = "Elevée";
   case Critical = "Critique";
}
