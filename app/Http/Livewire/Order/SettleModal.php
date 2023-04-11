<?php

namespace App\Http\Livewire\Order;

use App\Models\AllowedAmount;
use App\Models\Deduction;
use App\Models\DeductionTotal;
use App\Models\InternationalPayment;
use App\Models\Law;
use App\Models\Order;
use App\Models\PayableTotal;
use App\Models\Penalty;
use App\Models\PenaltyTotal;
use App\Models\PercentagePayable;
use App\Models\Protection;
use App\Models\Refinement;
use App\Models\Requirement;
use App\Models\Settlement;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SettleModal extends Component
{
    use LivewireAlert;

    public $open;
    public $page;
    public $orderId;
    public $withInvoice;
    public $internationalCopper;
    public $internationalSilver;
    public $internationalGold;
    public $copperLaw;
    public $humidity;
    public $decrease;
    public $silverLaw;
    public $silverFactor;
    public $goldLaw;
    public $goldFactor;
    public $copperPayable;
    public $silverPayable;
    public $goldPayable;
    public $copperProtection;
    public $silverProtection;
    public $goldProtection;
    public $copperDeduction;
    public $silverDeduction;
    public $goldDeduction;
    public $copperRefinement;
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
        $this->orderId = 0;
        $this->withInvoice = false;
        $this->internationalCopper = "";
        $this->internationalSilver = "";
        $this->internationalGold = "";
        $this->copperLaw = "";
        $this->humidity = "";
        $this->decrease = "";
        $this->silverLaw = "";
        $this->silverFactor = 1;
        $this->goldLaw = "";
        $this->goldFactor = 1;
        $this->copperPayable = "";
        $this->silverPayable = "";
        $this->goldPayable = "";
        $this->copperProtection = "";
        $this->silverProtection = "";
        $this->goldProtection = "";
        $this->copperDeduction = "";
        $this->silverDeduction = "";
        $this->goldDeduction = "";
        $this->copperRefinement = "";
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

    protected $listeners = ['abrirModal','settle'];

    public function abrirModal($id){

        if(Order::find($id)->settled){
            $this->alert('warning', '¡Orden ya liquidada!', [
                'position' => 'top-right',
                'timer' => 3500,
                'toast' => true,
                'text' => 'Vaya a liquidaciones para más detalles'
            ]);
        }else{
            $this->resetValidation();
            $this->resetExcept('open');
            $this->page = 1;
            $this->orderId = $id;
            $this->silverFactor = 1.1023;
            $this->goldFactor = 1.1023;
            $this->arsenicPenalty = 0;
            $this->antomonyPenalty = 0;
            $this->leadPenalty = 0;
            $this->zincPenalty = 0;
            $this->bismuthPenalty = 0;
            $this->mercuryPenalty = 0;
            $this->arsenicMaximum = 0;
            $this->antomonyMaximum = 0;
            $this->leadMaximum = 0;
            $this->zincMaximum = 0;
            $this->bismuthMaximum = 0;
            $this->mercuryMaximum = 0;
            $this->open = true;
        }

    }

    protected function rules(){
        return [
            'internationalCopper' => 'required|decimal:0,3',
            'internationalSilver' => 'required|decimal:0,3',
            'internationalGold' => 'required|decimal:0,3',
            'copperLaw' => 'required|decimal:0,3',
            'humidity' => 'required|decimal:0,3',
            'decrease' => 'required|decimal:0,3',
            'silverLaw' => 'required|decimal:0,3',
            'silverFactor' => 'required|decimal:0,4',
            'goldLaw' => 'required|decimal:0,3',
            'goldFactor' => 'required|decimal:0,4',
            'copperPayable' => 'required|decimal:0,3',
            'silverPayable' => 'required|decimal:0,3',
            'goldPayable' => 'required|decimal:0,3',
            'copperProtection' => 'required|decimal:0,3',
            'silverProtection' => 'required|decimal:0,3',
            'goldProtection' => 'required|decimal:0,3',
            'copperDeduction' => 'required|decimal:0,3',
            'silverDeduction' => 'required|decimal:0,3',
            'goldDeduction' => 'required|decimal:0,3',
            'copperRefinement' => 'required|decimal:0,3',
            'silverRefinement' => 'required|decimal:0,3',
            'goldRefinement' => 'required|decimal:0,3',
            'maquila' => 'required|decimal:0,3',
            'analysis' => 'required|decimal:0,3',
            'stevedore' => 'required|decimal:0,3',
            'arsenicPenalty' => 'required|decimal:0,3',
            'antomonyPenalty' => 'required|decimal:0,3',
            'leadPenalty' => 'required|decimal:0,3',
            'zincPenalty' => 'required|decimal:0,3',
            'bismuthPenalty' => 'required|decimal:0,3',
            'mercuryPenalty' => 'required|decimal:0,3',
            'arsenicMaximum' => 'required|decimal:0,3',
            'antomonyMaximum' => 'required|decimal:0,3',
            'leadMaximum' => 'required|decimal:0,3',
            'zincMaximum' => 'required|decimal:0,3',
            'bismuthMaximum' => 'required|decimal:0,3',
            'mercuryMaximum' => 'required|decimal:0,3',
        ];
    }

    public function messages(){
        return [
            'internationalCopper.required' => 'El campo es requerido',
            'internationalSilver.required' => 'El campo es requerido',
            'internationalGold.required' => 'El campo es requerido',
            'copperLaw.required' => 'El campo es requerido',
            'humidity.required' => 'El campo es requerido',
            'decrease.required' => 'El campo es requerido',
            'silverLaw.required' => 'El campo es requerido',
            'silverFactor.required' => 'El campo es requerido',
            'goldLaw.required' => 'El campo es requerido',
            'goldFactor.required' => 'El campo es requerido',
            'copperPayable.required' => 'El campo es requerido',
            'silverPayable.required' => 'El campo es requerido',
            'goldPayable.required' => 'El campo es requerido',
            'copperProtection.required' => 'El campo es requerido',
            'silverProtection.required' => 'El campo es requerido',
            'goldProtection.required' => 'El campo es requerido',
            'copperDeduction.required' => 'El campo es requerido',
            'silverDeduction.required' => 'El campo es requerido',
            'goldDeduction.required' => 'El campo es requerido',
            'copperRefinement.required' => 'El campo es requerido',
            'silverRefinement.required' => 'El campo es requerido',
            'goldRefinement.required' => 'El campo es requerido',
            'maquila.required' => 'El campo es requerido',
            'analysis.required' => 'El campo es requerido',
            'stevedore.required' => 'El campo es requerido',
            'arsenicPenalty.required' => 'El campo es requerido',
            'antomonyPenalty.required' => 'El campo es requerido',
            'leadPenalty.required' => 'El campo es requerido',
            'zincPenalty.required' => 'El campo es requerido',
            'bismuthPenalty.required' => 'El campo es requerido',
            'mercuryPenalty.required' => 'El campo es requerido',
            'arsenicMaximum.required' => 'El campo es requerido',
            'antomonyMaximum.required' => 'El campo es requerido',
            'leadMaximum.required' => 'El campo es requerido',
            'zincMaximum.required' => 'El campo es requerido',
            'bismuthMaximum.required' => 'El campo es requerido',
            'mercuryMaximum.required' => 'El campo es requerido',

            'internationalCopper.decimal' => '3 decimales como máximo',
            'internationalSilver.decimal' => '3 decimales como máximo',
            'internationalGold.decimal' => '3 decimales como máximo',
            'copperLaw.decimal' => '3 decimales como máximo',
            'humidity.decimal' => '3 decimales como máximo',
            'decrease.decimal' => '3 decimales como máximo',
            'silverLaw.decimal' => '3 decimales como máximo',
            'silverFactor.decimal' => '4 decimales como máximo',
            'goldLaw.decimal' => '3 decimales como máximo',
            'goldFactor.decimal' => '4 decimales como máximo',
            'copperPayable.decimal' => '3 decimales como máximo',
            'silverPayable.decimal' => '3 decimales como máximo',
            'goldPayable.decimal' => '3 decimales como máximo',
            'copperProtection.decimal' => '3 decimales como máximo',
            'silverProtection.decimal' => '3 decimales como máximo',
            'goldProtection.decimal' => '3 decimales como máximo',
            'copperDeduction.decimal' => '3 decimales como máximo',
            'silverDeduction.decimal' => '3 decimales como máximo',
            'goldDeduction.decimal' => '3 decimales como máximo',
            'copperRefinement.decimal' => '3 decimales como máximo',
            'silverRefinement.decimal' => '3 decimales como máximo',
            'goldRefinement.decimal' => '3 decimales como máximo',
            'maquila.decimal' => '3 decimales como máximo',
            'analysis.decimal' => '3 decimales como máximo',
            'stevedore.decimal' => '3 decimales como máximo',
            'arsenicPenalty.decimal' => '3 decimales como máximo',
            'antomonyPenalty.decimal' => '3 decimales como máximo',
            'leadPenalty.decimal' => '3 decimales como máximo',
            'zincPenalty.decimal' => '3 decimales como máximo',
            'bismuthPenalty.decimal' => '3 decimales como máximo',
            'mercuryPenalty.decimal' => '3 decimales como máximo',
            'arsenicMaximum.decimal' => '3 decimales como máximo',
            'antomonyMaximum.decimal' => '3 decimales como máximo',
            'leadMaximum.decimal' => '3 decimales como máximo',
            'zincMaximum.decimal' => '3 decimales como máximo',
            'bismuthMaximum.decimal' => '3 decimales como máximo',
            'mercuryMaximum.decimal' => '3 decimales como máximo',
        ];
    }

    public function confirmSettle(){
        if(Order::find($this->orderId)->settled){
            $this->alert('warning', '¡Orden ya liquidada!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }else{
            $this->alert('question','¿Estas seguro de liquidar?',[
                'showConfirmButton' => true,
                'confirmButtonText' => 'Sí',
                'position' => 'center',
                'toast' => false,
                'showCancelButton' => true,
                'cancelButtonText' => 'No',
                'timer' => 10000,
                'onConfirmed' => 'settle',
            ]);

        }
    }

    public function settle(){
        $this->validate();
        try{
            DB::transaction(function(){
                    $order = Order::find($this->orderId);
                    $order->settled = true;

                    $settlement = Settlement::create([
                        'order_id' => $this->orderId,
                        'batch' => $this->createBatch(),
                        'with_invoice' => true,
                        'user_id' => Auth::user()->id
                    ]);

                    $internationalPayment = new InternationalPayment();
                    $internationalPayment->settlement_id = $settlement->id;
                    $internationalPayment->copper = $this->internationalCopper;
                    $internationalPayment->silver = $this->internationalSilver;
                    $internationalPayment->gold = $this->internationalGold;
                    $internationalPayment->save();

                    $percentagePayable = new PercentagePayable();
                    $percentagePayable->settlement_id = $settlement->id;
                    $percentagePayable->copper = $this->copperPayable;
                    $percentagePayable->silver = $this->silverPayable;
                    $percentagePayable->gold = $this->goldPayable;
                    $percentagePayable->save();

                    $law = new Law();
                    $law->settlement_id = $settlement->id;
                    $law->copper = $this->copperLaw;
                    $law->humidity = $this->humidity;
                    $law->decrease = $this->decrease;
                    $law->silver = $this->silverLaw;
                    $law->silver_factor = $this->silverFactor;
                    $law->gold = $this->goldLaw;
                    $law->gold_factor = $this->goldFactor;
                    $law->tms = $order->wmt*(100-$this->humidity)/100;
                    $law->tmns = $law->tms*(100-$law->decrease)/100;

                    $protection = new Protection();
                    $protection->settlement_id = $settlement->id;
                    $protection->copper = $this->copperProtection;
                    $protection->silver = $this->silverProtection;
                    $protection->gold = $this->goldProtection;
                    $protection->save();

                    $deduction = new Deduction();
                    $deduction->settlement_id = $settlement->id;
                    $deduction->copper = $this->copperDeduction;
                    $deduction->silver = $this->silverDeduction;
                    $deduction->gold = $this->goldDeduction;
                    $deduction->save();

                    $refinement = new Refinement();
                    $refinement->settlement_id = $settlement->id;
                    $refinement->copper = $this->copperRefinement;
                    $refinement->silver = $this->silverRefinement;
                    $refinement->gold = $this->goldRefinement;
                    $refinement->save();

                    $requirement = new Requirement();
                    $requirement->settlement_id = $settlement->id;
                    $requirement->maquila = $this->maquila;
                    $requirement->analysis = $this->analysis;
                    $requirement->stevedore = $this->stevedore;
                    $requirement->save();

                    $penalty = new Penalty();
                    $penalty->settlement_id = $settlement->id;
                    $penalty->arsenic = $this->arsenicPenalty;
                    $penalty->antomony = $this->antomonyPenalty;
                    $penalty->lead = $this->leadPenalty;
                    $penalty->zinc = $this->zincPenalty;
                    $penalty->bismuth = $this->bismuthPenalty;
                    $penalty->mercury = $this->mercuryPenalty;
                    $penalty->save();

                    $allowedAmount = new AllowedAmount();
                    $allowedAmount->settlement_id = $settlement->id;
                    $allowedAmount->arsenic = $this->arsenicMaximum;
                    $allowedAmount->antomony = $this->antomonyMaximum;
                    $allowedAmount->lead = $this->leadMaximum;
                    $allowedAmount->zinc = $this->zincMaximum;
                    $allowedAmount->bismuth = $this->bismuthMaximum;
                    $allowedAmount->mercury = $this->mercuryMaximum;

                    $payableTotal = new PayableTotal();
                    $payableTotal->settlement_id = $settlement->id;

                    $payableTotalCopperPercent = ($this->copperLaw*$this->copperPayable-$this->copperDeduction)/100;
                    $payableTotal->unit_price_copper =round(($this->internationalCopper - $this->copperProtection)*2204.62,2, PHP_ROUND_HALF_DOWN);
                    $payableTotal->total_price_copper =round($payableTotal->unit_price_copper*$payableTotalCopperPercent,3, PHP_ROUND_HALF_DOWN);

                    $payableTotalSilverPercent = ($this->copperLaw*$this->copperPayable-$this->copperDeduction)/100;
                    $payableTotal->unit_price_silver =round(($this->internationalSilver - $this->silverProtection)*2204.62,2, PHP_ROUND_HALF_DOWN);
                    $payableTotal->total_price_silver =round(($payableTotal->unit_price_silver*$payableTotalSilverPercent),3, PHP_ROUND_HALF_DOWN);

                    $payableTotalGoldPercent = ($this->copperLaw*$this->copperPayable-$this->copperDeduction)/100;
                    $payableTotal->unit_price_gold =round(($this->internationalGold - $this->goldProtection)*2204.62,2, PHP_ROUND_HALF_DOWN);
                    $payableTotal->total_price_gold =round(($payableTotal->unit_price_gold*$payableTotalGoldPercent),3, PHP_ROUND_HALF_DOWN);

                    $deductionTotal = new DeductionTotal();
                    $deductionTotal->settlement_id = $settlement->id;

                    $deductionTotal->unit_price_copper = round(2204.62*$this->copperRefinement,3,PHP_ROUND_HALF_DOWN);
                    $deductionTotal->total_price_copper = round($payableTotalCopperPercent*$deductionTotal->unit_price_copper,3,PHP_ROUND_HALF_DOWN);

                    $deductionTotal->unit_price_silver = round(2204.62*$this->silverRefinement,3,PHP_ROUND_HALF_DOWN);
                    $deductionTotal->total_price_silver = round($payableTotalSilverPercent*$deductionTotal->unit_price_silver,3,PHP_ROUND_HALF_DOWN);

                    $deductionTotal->unit_price_gold = round(2204.62*$this->goldRefinement,3,PHP_ROUND_HALF_DOWN);
                    $deductionTotal->total_price_gold = round($payableTotalGoldPercent*$deductionTotal->unit_price_gold,3,PHP_ROUND_HALF_DOWN);

                    $deductionTotal->maquila = $this->maquila;
                    $deductionTotal->analysis = $this->analysis/$law->tmns;
                    $deductionTotal->stevedore = $this->stevedore*$order->wmt;

                    $penaltyTotal = new PenaltyTotal();
                    $penaltyTotal->settlement_id = $settlement->id;

                    $penaltyTotal->leftover_arsenic = $this->arsenicPenalty - $this->arsenicMaximum > 0 ? $this->arsenicPenalty - $this->arsenicMaximum : 0;
                    $penaltyTotal->leftover_antomony = $this->antomonyPenalty - $this->antomonyMaximum > 0 ? $this->antomonyPenalty - $this->antomonyMaximum : 0;
                    $penaltyTotal->leftover_lead = $this->leadPenalty - $this->leadMaximum > 0 ? $this->leadPenalty - $this->leadMaximum : 0;
                    $penaltyTotal->leftover_zinc = $this->zincPenalty - $this->zincMaximum > 0 ? $this->zincPenalty - $this->zincMaximum : 0;
                    $penaltyTotal->leftover_bismuth = $this->bismuthPenalty - $this->bismuthMaximum > 0 ? $this->bismuthPenalty - $this->bismuthMaximum : 0;
                    $penaltyTotal->leftover_mercury = $this->mercuryPenalty - $this->mercuryMaximum > 0 ? $this->mercuryPenalty - $this->mercuryMaximum : 0;

                    $penaltyTotal->total_arsenic = $penaltyTotal->leftover_arsenic*100;
                    $penaltyTotal->total_antomony = round($penaltyTotal->leftover_antomony*106.5,3,PHP_ROUND_HALF_DOWN);
                    $penaltyTotal->total_lead = $penaltyTotal->leftover_lead*5;
                    $penaltyTotal->total_zinc = $penaltyTotal->leftover_zinc*5;
                    $penaltyTotal->total_bismuth = $penaltyTotal->leftover_bismuth*500;
                    $penaltyTotal->total_mercury = $penaltyTotal->leftover_mercury/2;

                    $penaltyTotal->save();

                    $law->save();
                    $payableTotal->save();
                    $order->save();
                    $allowedAmount->save();
                    $deductionTotal->save();
            });
            $this->emitTo('order.base', 'render');
            $this->alert('success', 'Orden Liquidada', [
                'position' => 'top-right',
                'timer' => 3500,
                'toast' => true,
               ]);
            $this->open = false;
        }catch(\Exception $e){
            $this->alert('error', $e, [
                'position' => 'center',
                'timer' => 100000,
                'toast' => false,
               ]);
        }

    }

    public function createBatch(){
        $fecha = 'L'.Carbon::now()->isoFormat('YYMM');
        $correlativo = '0001';
        if(Settlement::limit(1)->exists()){
            $last_batch = explode("-",Settlement::latest()->first()->batch);
            if($fecha == $last_batch[0]){
                $correlativo = str_pad(strval(intval($last_batch[1])+1),4,0,STR_PAD_LEFT);
            }
        }

        return $fecha.'-'.$correlativo;
    }

    public function render()
    {
        return view('livewire.order.settle-modal');
    }
}
