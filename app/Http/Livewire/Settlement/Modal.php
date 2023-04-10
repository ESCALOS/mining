<?php

namespace App\Http\Livewire\Settlement;

use App\Models\Settlement;
use Livewire\Component;

class Modal extends Component
{
    public $open;
    public $page;
    public $settlementId;
    public $internationalCupper;
    public $internationalSilver;
    public $internationalGold;
    public $cupperLaw;
    public $humidity;
    public $decrease;
    public $silverLaw;
    public $silverFactor;
    public $goldLaw;
    public $goldFactor;
    public $cupperPayable;
    public $silverPayable;
    public $goldPayable;
    public $cupperProtection;
    public $silverProtection;
    public $goldProtection;
    public $cupperDeduction;
    public $silverDeduction;
    public $goldDeduction;
    public $cupperRefinement;
    public $silverRefinement;
    public $goldRefinement;
    public $maquila;
    public $analysis;
    public $stevedore;
    public $arsenicPenalty;
    public $antomonyPenalty;
    public $leadPenalty;
    public $zincPenalty;
    public $bismuthPenalty;
    public $mercuryPenalty;
    public $arsenicMaximum;
    public $antomonyMaximum;
    public $leadMaximum;
    public $zincMaximum;
    public $bismuthMaximum;
    public $mercuryMaximum;

    public function mount(){
        $this->open = false;
        $this->page = 1;
        $this->internationalCupper = "";
        $this->internationalSilver = "";
        $this->internationalGold = "";
        $this->cupperLaw = "";
        $this->humidity = "";
        $this->decrease = "";
        $this->silverLaw = "";
        $this->silverFactor = 1;
        $this->goldLaw = "";
        $this->goldFactor = 1;
        $this->cupperPayable = "";
        $this->silverPayable = "";
        $this->goldPayable = "";
        $this->cupperProtection = "";
        $this->silverProtection = "";
        $this->goldProtection = "";
        $this->cupperDeduction = "";
        $this->silverDeduction = "";
        $this->goldDeduction = "";
        $this->cupperRefinement = "";
        $this->silverRefinement = "";
        $this->goldRefinement = "";
        $this->maquila = "";
        $this->analysis = "";
        $this->stevedore = "";
        $this->arsenicPenalty = "";
        $this->antomonyPenalty = "";
        $this->leadPenalty = "";
        $this->zincPenalty = "";
        $this->bismuthPenalty = "";
        $this->mercuryPenalty = "";
        $this->arsenicMaximum = "";
        $this->antomonyMaximum = "";
        $this->leadMaximum = "";
        $this->zincMaximum = "";
        $this->bismuthMaximum = "";
        $this->mercuryMaximum = "";
    }

    protected $listeners = ['abrirModal'];

    public function abrirModal($id){
        $this->resetValidation();
        $this->resetExcept('open');
        $this->page = 1;
        $this->settlementId = $id;
        if($id > 0){
            $settlement = Settlement::find($id);
            $this->internationalCupper = $settlement->InternationalPayment->cupper;
            $this->internationalSilver = $settlement->InternationalPayment->silver;
            $this->internationalGold = $settlement->InternationalPayment->gold;
            $this->cupperLaw = $settlement->Law->cupper;
            $this->humidity = $settlement->Law->humidity;
            $this->decrease = $settlement->Law->decrease;
            $this->silverLaw = $settlement->Law->silver;
            $this->silverFactor = $settlement->Law->silver_factor;
            $this->goldLaw = $settlement->Law->gold;
            $this->goldFactor = $settlement->Law->gold_factor;
            $this->cupperPayable = $settlement->PercentagePayable->cupper;
            $this->silverPayable = $settlement->PercentagePayable->silver;
            $this->goldPayable = $settlement->PercentagePayable->gold;
            $this->cupperProtection = $settlement->Protection->cupper;
            $this->silverProtection = $settlement->Protection->silver;
            $this->goldProtection = $settlement->Protection->gold;
            $this->cupperDeduction = $settlement->Deduction->cupper;
            $this->silverDeduction = $settlement->Deduction->silver;
            $this->goldDeduction = $settlement->Deduction->gold;
            $this->cupperRefinement = $settlement->Refinement->cupper;
            $this->silverRefinement = $settlement->Refinement->silver;
            $this->goldRefinement = $settlement->Refinement->gold;
            $this->maquila = $settlement->Requirement->maquila;
            $this->analysis = $settlement->Requirement->analysis;
            $this->stevedore = $settlement->Requirement->stevedore;
            $this->arsenicPenalty = $settlement->Penalty->arsenic;
            $this->antomonyPenalty = $settlement->Penalty->antomony;
            $this->leadPenalty = $settlement->Penalty->lead;
            $this->zincPenalty = $settlement->Penalty->zinc;
            $this->bismuthPenalty = $settlement->Penalty->bismuth;
            $this->mercuryPenalty = $settlement->Penalty->mercury;
            $this->arsenicMaximum = $settlement->AllowedAmount->arsenic;
            $this->antomonyMaximum = $settlement->AllowedAmount->antomony;
            $this->leadMaximum = $settlement->AllowedAmount->lead;
            $this->zincMaximum = $settlement->AllowedAmount->zinc;
            $this->bismuthMaximum = $settlement->AllowedAmount->bismuth;
            $this->mercuryMaximum = $settlement->AllowedAmount->mercury;
        }
        $this->open = true;
    }

    public function registrar(){
        $this->validate();
    }

    public function render()
    {
        return view('livewire.settlement.modal');
    }
}
