<?php

    namespace App\Livewire\Admin;

    use Illuminate\View\View;
    use Livewire\Attributes\Layout;
    use Livewire\Component;

    class Panel extends Component
    {

        #[Layout('layouts.admin.admin', [
            'title'=>'پنل مدیریت',
            'breadcrumb' => [
                ['label' => 'پنل مدیریت']
            ]

        ])]
        public function render(): View
        {
            return view('livewire.admin.panel');
        }
    }
