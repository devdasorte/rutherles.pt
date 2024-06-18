<?php


use Livewire\Volt\Component;


new class extends Component {


    public array $tags = ['segurança', 'suporte', 'servidor'];
    public $name;
    public $id;
    public  $vantagem ;


  
    
};

?>


<link id="tw-1" rel="stylesheet" href="{{ asset('assets/build/assets/app-CLXaZiM_.css') }}">

@props(['name' , 'id' , 'vantagem'])
<div>

 @php 
    
    if($vantagem){

        $array = explode(',', trim($vantagem,'"'));
        
        $this->tags = array_map('html_entity_decode', $array);
    }
   
@endphp

<x-painel-tags label="Escolha as vantagens do plano"   id="{{$id}}" name="{{$name}}" hint="Digite as vantagens e aperte enter"  wire:model="tags"  />

</div>