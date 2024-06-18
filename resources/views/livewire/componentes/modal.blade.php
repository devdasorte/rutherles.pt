<?php
use Livewire\Volt\Component;


new class extends Component {


    public $myModal4 ;
    public $id ;



}

?>

@props(['id'])



<div>

<x-painel-modal id="{{$id}}"  wire:model="myModal4" class="backdrop-blur" box-class="bg-red-50 p-10 w-64">
    Hello!
</x-painel-modal>
 
<x-painel-button label="Open " @click="$wire.myModal4 = true" />

</div>