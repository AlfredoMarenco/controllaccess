<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Code;
use Livewire\Component;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;
use Illuminate\Database\Eloquent\Builder;

class DashboardComponent extends Component
{
    public function render()
    {
        $scanner = Code::where('status','!=','1')->count();
        $actives = Code::where('status','=','1')->count();
        $pieChartOcupation = LivewireCharts::pieChartModel()
        ->setTitle('Reporte de ocupación del evento')
        ->setDataLabelsEnabled('Por Ingresar','Ingresados')
        ->withDataLabels()
        ->setOpacity(1)
        ->legendHorizontallyAlignedCenter()
        ->setDataLabelsEnabled(true)
        ->addSlice('Ingresados', $scanner, '#3CF55D')
        ->addSlice('Por Ingresar', $actives, '#F02E1F');

        $oro_scanner = Code::whereHas('box',function(Builder $query){
            $query->where('name','ORO');
        })->where('status','!=','1')->count();

        $platino_scanner = Code::whereHas('box',function(Builder $query){
            $query->where('name','PLATINO');
        })->where('status','!=','1')->count();


        $oro_actives = Code::whereHas('box',function(Builder $query){
            $query->where('name','ORO');
        })->where('status','=','1')->count();

        $platino_actives = Code::whereHas('box',function(Builder $query){
            $query->where('name','PLATINO');
        })->where('status','=','1')->count();

        $pieChartForSections = LivewireCharts::columnChartModel()
        ->setTitle('Reporte de ocupación del evento')
        ->setDataLabelsEnabled('Oro','Platino')
        ->withDataLabels()
        ->setOpacity(1)
        ->legendHorizontallyAlignedCenter()
        ->setDataLabelsEnabled(true)
        ->addColumn('Oro Escaneados', $oro_scanner, '#C28E13')
        ->addColumn('Oro No escaneados', $oro_actives, '#EBDB8F')
        ->addColumn('Platino Escaneados', $platino_scanner, '#C6C0C1')
        ->addColumn('Platino No Escaneado', $platino_actives, '#D3DCDE');

        return view('livewire.admin.dashboard-component',[
            'pieChartOcupation' => $pieChartOcupation,
            'pieChartForSections' => $pieChartForSections
        ]);
    }
}
