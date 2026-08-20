@php
    $org = Auth::user()->organization;
    $plan = strtolower($org->subscription->plan->slug ?? 'basic');
    $isUnlocked = in_array($plan, ['pro', 'premium', 'elite']);
    $chatRoute = route('ai-copilot.chat');
    $upgradeRoute = route('clinic.subscription');
    $userName = Auth::user()->name;
@endphp

<div x-data="aiCopilot()" class="fixed bottom-6 right-6 z-[9999] flex flex-col items-end" @keydown.escape.window="open = false">

    {{-- Chat Panel --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4" style="display:none;" class="mb-4 w-96 max-h-[600px] bg-white rounded-3xl shadow-2xl shadow-gray-900/20 border border-gray-100 flex flex-col overflow-hidden">

        {{-- Header --}}
        <div class="bg-gradient-to-r from-[#39D3C4] to-[#12a19b] px-5 py-4 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-white">Dental Copilot</h3>
                    <div class="flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-300 animate-pulse"></span>
                        <p class="text-[10px] text-white/80 font-medium">@if($isUnlocked) AI Assistant Active @else Upgrade to unlock @endif</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $isUnlocked ? 'bg-white/20 text-white' : 'bg-amber-400/30 text-amber-100' }}">{{ strtoupper($plan) }}</span>
                <button @click="open = false" class="text-white/70 hover:text-white p-1 rounded-lg hover:bg-white/10 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>

        @if(!$isUnlocked)
        <div class="bg-amber-50 border-b border-amber-100 px-4 py-3 flex items-center gap-3">
            <div class="p-2 bg-amber-100 rounded-lg shrink-0">
                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-amber-800">Requires Pro or Premium Plan</p>
                <a href="{{ $upgradeRoute }}" class="text-xs text-amber-600 font-bold underline">Upgrade now</a>
            </div>
        </div>
        @endif

        {{-- Chat Body --}}
        <div x-ref="chatBody" class="flex-1 overflow-y-auto p-4 space-y-4 min-h-[300px]">
            <template x-if="history.length === 0">
                <div class="flex flex-col items-center text-center py-6 px-2">
                    <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center mb-3">
                        <svg class="w-7 h-7 text-[#39D3C4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Hello, Dr. {{ $userName }}!</h4>
                    <p class="text-xs text-gray-500 mb-4">I have access to your clinic's live data. Ask me anything.</p>
                    @if($isUnlocked)
                    <div class="w-full space-y-2">
                        <button @click="quickAsk('How many patients do I have today?')" class="w-full text-left text-xs px-3 py-2.5 rounded-xl bg-gray-50 hover:bg-teal-50 border border-gray-200 hover:border-teal-200 text-gray-600 transition-all font-medium">📅 How many patients today?</button>
                        <button @click="quickAsk('What is my revenue this month?')" class="w-full text-left text-xs px-3 py-2.5 rounded-xl bg-gray-50 hover:bg-teal-50 border border-gray-200 hover:border-teal-200 text-gray-600 transition-all font-medium">💰 What is my revenue this month?</button>
                        <button @click="quickAsk('Are there any items with low stock?')" class="w-full text-left text-xs px-3 py-2.5 rounded-xl bg-gray-50 hover:bg-teal-50 border border-gray-200 hover:border-teal-200 text-gray-600 transition-all font-medium">📦 Any low stock items?</button>
                    </div>
                    @endif
                </div>
            </template>

            <template x-for="(msg, i) in history" :key="i">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <template x-if="msg.role === 'assistant'">
                        <div class="h-7 w-7 rounded-xl bg-gradient-to-br from-[#39D3C4] to-[#12a19b] flex items-center justify-center mr-2 shrink-0 mt-0.5 shadow-sm">
                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                        </div>
                    </template>
                    <div :class="msg.role === 'user' ? 'bg-gradient-to-br from-[#39D3C4] to-[#12a19b] text-white rounded-3xl rounded-tr-sm max-w-[80%]' : 'bg-gray-50 border border-gray-100 text-gray-800 rounded-3xl rounded-tl-sm max-w-[85%]'" class="px-4 py-3 text-xs leading-relaxed shadow-sm" x-html="formatMessage(msg.content)"></div>
                </div>
            </template>

            <template x-if="loading">
                <div class="flex justify-start">
                    <div class="h-7 w-7 rounded-xl bg-gradient-to-br from-[#39D3C4] to-[#12a19b] flex items-center justify-center mr-2 shrink-0 shadow-sm">
                        <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                    </div>
                    <div class="bg-gray-50 border border-gray-100 rounded-3xl rounded-tl-sm px-4 py-3 flex items-center gap-1.5 shadow-sm">
                        <span class="w-1.5 h-1.5 bg-[#39D3C4] rounded-full animate-bounce" style="animation-delay:0ms"></span>
                        <span class="w-1.5 h-1.5 bg-[#39D3C4] rounded-full animate-bounce" style="animation-delay:150ms"></span>
                        <span class="w-1.5 h-1.5 bg-[#39D3C4] rounded-full animate-bounce" style="animation-delay:300ms"></span>
                    </div>
                </div>
            </template>
        </div>

        {{-- Input --}}
        <div class="p-3 border-t border-gray-100 bg-white shrink-0">
            <div class="flex items-end gap-2 bg-gray-50 rounded-2xl border border-gray-200 focus-within:border-[#39D3C4] focus-within:ring-2 focus-within:ring-teal-100 transition-all px-3 py-2">
                <textarea x-model="message" @keydown="handleKey($event)" :disabled="loading" rows="1" placeholder="{{ $isUnlocked ? 'Ask me anything about your clinic...' : 'Upgrade to Pro to use AI Copilot...' }}" class="flex-1 bg-transparent text-xs text-gray-800 placeholder-gray-400 resize-none focus:outline-none leading-relaxed max-h-24 py-0.5" {{ !$isUnlocked ? 'disabled' : '' }}></textarea>
                <button @click="send()" :disabled="!message.trim() || loading || !unlocked" :class="message.trim() && !loading && unlocked ? 'bg-[#39D3C4] hover:bg-[#2db3a6]' : 'bg-gray-200 cursor-not-allowed'" class="h-7 w-7 rounded-xl flex items-center justify-center transition-all shrink-0">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </div>
            <p class="text-[10px] text-gray-400 text-center mt-2">Powered by Dentiste.ma AI &middot; Enter to send</p>
        </div>
    </div>

    {{-- Toggle Button --}}
    <button @click="open = !open" :class="open ? 'bg-gray-700' : 'bg-gradient-to-br from-[#39D3C4] to-[#12a19b] hover:scale-110'" class="h-14 w-14 rounded-2xl flex items-center justify-center shadow-xl transition-all duration-300 relative">
        @if($isUnlocked)
        <span class="absolute inset-0 rounded-2xl animate-ping bg-teal-400/30" x-show="!open"></span>
        @endif
        <svg x-show="!open" class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
        <svg x-show="open" class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        @if(!$isUnlocked)
        <span class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-amber-400 border-2 border-white flex items-center justify-center">
            <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </span>
        @endif
    </button>

</div>

<script>
var _copilotUrl = '{{ $chatRoute }}';
var _copilotUnlocked = {{ $isUnlocked ? 'true' : 'false' }};

function aiCopilot() {
    return {
        open: false,
        loading: false,
        message: '',
        history: [],
        unlocked: _copilotUnlocked,

        quickAsk: function(q) {
            this.message = q;
            this.send();
        },

        send: async function() {
            if (!this.message.trim() || this.loading) return;
            var userMsg = this.message.trim();
            this.history.push({ role: 'user', content: userMsg });
            this.message = '';
            this.loading = true;
            this.scrollToBottom();
            try {
                var csrfEl = document.querySelector('meta[name=csrf-token]');
                var csrf = csrfEl ? csrfEl.content : '';
                var resp = await fetch(_copilotUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify({ message: userMsg, history: this.history.slice(-10) })
                });
                var data = await resp.json();
                if (data.locked) {
                    this.history.push({ role: 'assistant', content: 'The AI Copilot requires a Pro or Premium plan. Please upgrade your subscription.' });
                } else if (data.success) {
                    this.history.push({ role: 'assistant', content: data.reply });
                } else {
                    this.history.push({ role: 'assistant', content: data.message || 'An error occurred.' });
                }
            } catch(e) {
                this.history.push({ role: 'assistant', content: 'Connection error. Please try again.' });
            } finally {
                this.loading = false;
                this.scrollToBottom();
            }
        },

        scrollToBottom: function() {
            var self = this;
            this.$nextTick(function() {
                var el = self.$refs.chatBody;
                if (el) el.scrollTop = el.scrollHeight;
            });
        },

        handleKey: function(e) {
            if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); this.send(); }
        },

        formatMessage: function(text) {
            var t = String(text);
            t = t.replace(/\*\*([\s\S]*?)\*\*/g, function(a, b) { return '<strong>' + b + '</strong>'; });
            t = t.replace(/\*([\s\S]*?)\*/g,     function(a, b) { return '<em>' + b + '</em>'; });
            t = t.replace(/`([\s\S]*?)`/g,       function(a, b) { return '<code style="background:#f3f4f6;color:#0d9488;padding:1px 4px;border-radius:3px;font-size:11px">' + b + '</code>'; });
            t = t.replace(/\n/g, '<br>');
            return t;
        }
    };
}
</script>
