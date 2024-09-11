<?php

use Livewire\Volt\Component;
use \App\Jobs\ProcessPodcastUrl;
use \App\Models\Episode;
use \App\Models\ListeningParty;

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

        $episode = Episode::create([
            'media_url' => $this->mediaUrl,
        ]);

        $listeningParty = ListeningParty::create([
            'name' => $this->name,
            'episode_id' => $episode->id,
            'start_time' => $this->startTime,
        ]);

        ProcessPodcastUrl::dispatch($this->mediaUrl, $listeningParty, $episode);

        return redirect()->route('parties.show', $listeningParty);
    }

    public function with(): array
    {
        return [
            'listening_parties' => ListeningParty::all(),
        ];
    }

}; ?>

<div class="flex items-center justify-center min-h-screen gb-slate-50">
    <div class="max-w-lg w-full px-4">
        <form wire:submit="createListeningParty" class="space-y-6">
            <x-input wire:model="name" placeholder="Listening Party Name" />
            <x-input wire:model="mediaUrl" placeholder="Podcast RSS Feed URL" description="Entering the RSS Feed URL will grab the latest episode" />
            <x-datetime-picker wire:model='startTime' placeholder="Listening Party Start Time" :min="now()->subDay()" requires-confirmation />
            <x-button type="submit">Create Listening Party</x-button>
        </form>
    </div>
</div>
