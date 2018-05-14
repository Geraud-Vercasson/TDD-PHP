<?php
/**
 * Created by PhpStorm.
 * User: laurentbeauvisage
 * Date: 07/05/2018
 * Time: 14:07
 */

namespace App;


use Mockery\Exception;

class DonationFee
{

    private $donation;
    private $commissionPercentage;
    private const FIXED_FEE = 50;

    public function __construct($donation, $commissionPercentage)
    {
        if ($commissionPercentage < 0 || $commissionPercentage > 30) {
            throw new Exception('Commission percentage out of bounds dude!');
        }

        if ($donation < 100) {
            throw new Exception('Donation must be at least 100 cents dumbass!');
        }

        if (!is_int($donation)) {
            throw new Exception('Donation must be an integer, bro!');
        }
        $this->donation = $donation;
        $this->commissionPercentage = $commissionPercentage;
    }

    /* Modification du return */

    public function getCommissionAmount()
    {
        return ($this->commissionPercentage/100) * $this->donation;
    }

    public function getAmountCollected()
    {
        return $this->donation - $this->getFixedAndCommissionFeeAmount();
    }

    public function getFixedAndCommissionFeeAmount(){
        $fixedAndCommissionFeeAmount = $this->getCommissionAmount() + self::FIXED_FEE;

        return $fixedAndCommissionFeeAmount <= 500? $fixedAndCommissionFeeAmount : 500;
    }

    public function getSummary()
    {
        $summary = [];
        $summary['donation'] = $this->donation;
        $summary['fixedFee'] = self::FIXED_FEE;
        $summary['commission'] = $this->getCommissionAmount();
        $summary['fixedAndCommission'] = $this->getFixedAndCommissionFeeAmount();
        $summary['amountCollected'] = $this->getAmountCollected();

        return $summary;
    }
}