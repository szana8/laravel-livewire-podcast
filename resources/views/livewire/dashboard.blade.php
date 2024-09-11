<?php

use Livewire\Volt\Component;

new class extends Component {

    #[\Livewire\Attributes\Validate('required|string|max:255')]
    public string $name = '';

    #[\Livewire\Attributes\Validate('url')]
    public string $mediaUrl = '';

    #[\Livewire\Attributes\Validate('required|date')]
    public DateTime $startTime;

    public function createListeningParty()
    {
        $this->validate();

        $episode = \App\Models\Episode::create([
            'media_url' => $this->mediaUrl,
        ]);

        $listeningParty = \App\Models\ListeningParty::create([
            'name' => $this->name,
            'episode_id' => $episode->id,
            'start_time' => $this->startTime,
        ]);

        return redirect()->route('parties.show', $listeningParty);
    }

    public function with()
    {
        return [
            'listening_parties' => \App\Models\ListeningParty::all(),
        ];
    }
}; ?>

<div class="flex items-center justify-center min-h-screen gb-slate-50">
    <div class="max-w-lg w-full px-4">
        <form wire:submit="createListeningParty" class="space-y-6">
            <x-input wire:model="name" placeholder="Listening Party Name" />
            <x-input wire:model="mediaUrl" placeholder="Podcast Episode URL" description="Direct Episode Link or Youtube Link, RSS Feeds will grab the latest episode" />
            <x-datetime-picker wire:model='startTime' placeholder="Listening Party Start Time" :min="now()->subDays(1)" requires-confirmation />
            <x-button type="submit">Create Listening Party</x-button>
        </form>
    </div>
</div>
