<div>
    @if($message )
        <div style="color: red;" class="error">{{ $message }}</div>
    @endif
    <div style="text-align: center; display: flex;">
        <button type="button" wire:click="decrement">-</button>
        <h1>{{$count}}</h1>
        <button type="button" wire:click="increment">+</button>
    </div>
</div>
