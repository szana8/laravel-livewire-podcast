<?php

use Livewire\Volt\Component;

new class extends Component {
    public \App\Models\ListeningParty $listeningParty;

    public function mount(\App\Models\ListeningParty $listeningParty): void
    {
        $this->listeningParty = $listeningParty;
    }
}; ?>

<div>
    Name: {{ $listeningParty->name }}
</div>
