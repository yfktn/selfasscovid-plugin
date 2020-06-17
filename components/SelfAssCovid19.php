<?php namespace Yfktn\SelfAssCovid\Components;

use Cms\Classes\ComponentBase;
use Auth;
use October\Rain\Exception\AjaxException;
use Yfktn\SelfAssCovid\Models\SelfAssCovid;

class SelfAssCovid19 extends ComponentBase 
{

    public function componentDetails()
    {
        return [
            'name'        => 'Self Assesment',
            'description' => 'Self Assesment form'
        ];
    }

    public function defineProperties()
    {
        return [
            'mustLogin' => [
                'title' => 'Pengakses Harus Login',
                'description' => "Bahwa yang mengisikan ini harus login dahulu!",
                'default' => 1,
                'type' => 'checkbox'
            ]
        ];
    }

    public function onRun()
    {
        $this->page['harusLogin'] = $this->property('mustLogin', 1);
    }

    public function onSubmit()
    {
        $harusLogin = post('harusLogin', false);
        $selfAssCovid = new SelfAssCovid;
        if( $harusLogin ) {
            if( !Auth::check() ) {
                throw new AjaxException(['#pesanServerSAC' => $this->renderPartial('@errornya', [
                    'errornya' => ['User harus login terlebih dahulu!']
                ])]);
            } else {
                $selfAssCovid->user_id = Auth::getUser()->id;
            }
        }

        $selfAssCovid->jawab01 = post('jawab01', 0);
        $selfAssCovid->jawab02 = post('jawab02', 0);
        $selfAssCovid->jawab03 = post('jawab03', 0);
        $selfAssCovid->jawab04 = post('jawab04', 0);
        $selfAssCovid->jawab05 = post('jawab05', 0);
        $selfAssCovid->jawab06 = post('jawab06', 0);
        $selfAssCovid->save();

        $this->page['nilaiResiko'] = $selfAssCovid->getNilaiResiko();
    }
}