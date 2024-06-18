<?php
use Livewire\Volt\Component;


new class extends Component {


    public $show = true;
    public $title = 'I have a shadow';
    public $icon = 'o-exclamation-triangle';
    public $shadow = true;
    public $actions = null;
    public $input = null;



}

?>

@props(['title', 'icon', 'shadow', 'actions', 'input'])

<x-painel-alert  title={{$title}} icon="o-exclamation-triangle" shadow >
    

  

    <x-slot name="actions">
        <div class="flex justify-end">
            
            <x-painel-button class="ml-2" wire:click="shadow = false">Close</x-painel-button>
        </div>
    </x-slot>
</x-painel-alert>