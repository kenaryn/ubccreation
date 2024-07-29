<?php

namespace App\Entity;

enum Proposal: string
{
   case Estimate = "Devis";
   case Bill = "Facture";
}
