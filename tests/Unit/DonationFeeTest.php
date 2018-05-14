<?php

namespace Tests\Unit;

use App\DonationFee;
use Mockery\Exception;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DonationFeeTest extends TestCase
{
    /**
     * Test de la commission prélevée par le site.
     *
     * @throws \Exception
     */
    public function testCommissionAmountGetter()
    {
        // Etant donné une donation de 100 et commission de 10%
        $donationFees = new DonationFee(100, 10);

        // Lorsque qu'on appel la méthode getCommissionAmount()
        $actual = $donationFees->getCommissionAmount();

        // Alors la Valeur de la commission doit être de 10
        $expected = 10;
        $this->assertEquals($expected, $actual);

        // Test sur de nouvelles valeurs :
        $donationFees = new DonationFee(200, 15);
        $actual = $donationFees->getCommissionAmount();
        $expected = 30;

        $this->assertEquals($expected, $actual);
    }

    public function testCollectedAmountGetter() {

        // Etant donné une donation de 100 et commission de 10%
        $donationFees = new DonationFee(100, 10);

        // Lorsque qu'on appel la méthode getCommissionAmount()
        $actual = $donationFees->getAmountCollected();

        // Alors la Valeur du montant perçu doit être de 90
        $expected = 90;
        $this->assertEquals($expected, $actual);

    }

    public function testExceptionCommissionPercentageTooHigh(){

        // La classe doit renvoyer une erreur si commissionPercentage n'est pas inférieure à 30 %

        $this->expectException(Exception::class);

        $commissionOutOfBounds = new DonationFee(100,35);
    }

    public function testExceptionCommissionPercentageTooLow(){
        // La classe doit renvoyer une erreur si commissionPercentage n'est pas supérieure à 0 %

        $this->expectException(Exception::class);

        $commissionOutOfBounds = new DonationFee(100, -2);
    }

    public function testExceptionDonationTooLow(){
        // La classe doit renvoyer une erreur si donation n'est pas supérieure ou égale à 100

        $this->expectException(Exception::class);

        $donationTooLow = new DonationFee(2, 10);

    }

    public function testExceptionDonationNotInteger(){

        $this->expectException(Exception::class);

        $donationNotInteger = new DonationFee(124.12, 10);
    }

    public function testFixedAndCommissionFeeAmountGetter(){
        // Etant donné une donation de 100 et commission de 10%
        $donationFees = new DonationFee(100, 10);

        // Lorsque qu'on appel la méthode getCommissionAmount()
        $actual = $donationFees->getFixedAndCommissionFeeAmount();

        // Alors la Valeur de la commission doit être de 60 (10 + 50)
        $expected = 60;
        $this->assertEquals($expected, $actual);

        // Test sur de nouvelles valeurs :
        $donationFees = new DonationFee(200, 15);
        $actual = $donationFees->getFixedAndCommissionFeeAmount();
        $expected = 80;

        $this->assertEquals($expected, $actual);

        $donationFees = new DonationFee(100000000000000, 30);
        $actual = $donationFees->getFixedAndCommissionFeeAmount();
        $expected = 500;

        $this->assertEquals($expected,$actual);
    }
}
