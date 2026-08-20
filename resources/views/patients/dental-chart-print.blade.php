<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dental Chart — {{ $patient->first_name }} {{ $patient->last_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print {
            #print-btn { display: none !important; }
            body { margin: 0; padding: 0; }
        }
        .print-header-area { display: flex; justify-content: space-between; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 15px; }
        .print-body-area   { display: flex; flex-direction: row; gap: 20px; }
        .print-chart-area  { width: 45%; display: flex; flex-direction: column; align-items: center; }
        .print-table-area  { width: 55%; }
        .print-table       { width: 100%; border-collapse: collapse; font-size: 12px; color: black; }
        .print-table th, .print-table td { border: 1px solid #000; padding: 6px; text-align: left; color: black; }
        .print-table th    { background-color: #f3f4f6; font-weight: bold; }
    </style>
</head>
<body class="bg-white text-black font-sans" x-data="odontogram()">

    {{-- Print Button --}}
    <div id="print-btn" class="no-print flex items-center gap-3 px-6 py-3 bg-white border-b border-gray-200 print:hidden">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-[#39D3C4] to-[#2db3a6] flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C9.5 2 7.5 3.5 6.5 5.5C5.5 4.5 4 4 3 5C1.5 6.5 2 9 3 10.5C2.5 11.5 2 12.5 2 14C2 17.5 4.5 20 7 21C8 21.5 9 21.5 10 21C10.5 20.5 11 20 11.5 19.5C12 19.5 12.5 19.5 13 20C13.5 20.5 14 21 15 21C17.5 20 22 17.5 22 14C22 12.5 21.5 11.5 21 10.5C22 9 22.5 6.5 21 5C20 4 18.5 4.5 17.5 5.5C16.5 3.5 14.5 2 12 2Z"/>
                </svg>
            </div>
            <div>
                <p class="font-extrabold text-gray-900 text-sm leading-none">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                <p class="text-xs text-gray-400">PT-{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }} &nbsp;|&nbsp; {{ $patient->phone ?? '' }}</p>
            </div>
        </div>
        <button onclick="window.print()"
                class="ml-auto flex items-center gap-2 px-5 py-2 bg-[#39D3C4] text-white rounded-xl text-sm font-bold hover:bg-[#2db3a6] transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Print
        </button>
        <a href="{{ route('patients.show', $patient) }}"
           class="flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-200 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back
        </a>
    </div>

    {{-- Print Content --}}
    <div class="p-8">
        <div class="print-header-area">
            @php
                $org     = auth()->user()->organization;
                $logoUrl = $org && $org->logo ? Storage::url($org->logo) : null;
            @endphp
            <div class="flex items-start gap-4">
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="Logo" class="max-h-16 w-24 object-contain">
                @endif
                <div>
                    <h1 class="text-xl font-black text-black uppercase leading-none mb-1">{{ $org->name ?? 'DENTAL CLINIC' }}</h1>
                    <p class="text-xs text-gray-600">{{ $org->address ?? '' }}</p>
                    <p class="text-xs text-gray-600">{{ $org->phone ? 'Tel: '.$org->phone : '' }}</p>
                    <p class="text-sm font-bold text-black mt-1">Dr. __________________</p>
                </div>
            </div>
            <div class="text-right text-xs leading-snug">
                <p><strong>Patient:</strong> {{ $patient->first_name }} {{ $patient->last_name }}</p>
                <p><strong>ID:</strong> PT-{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</p>
                @if($patient->date_of_birth)
                    <p><strong>Age:</strong> {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} ans</p>
                @endif
                <p><strong>Tel:</strong> {{ $patient->phone ?? '..................' }}</p>
                <p><strong>CNSS / Mutuelle:</strong> ......................................</p>
                <p><strong>Date:</strong> {{ date('d/m/Y') }}</p>
            </div>
        </div>

        <div class="print-body-area">
            {{-- Chart --}}
            <div class="print-chart-area">
                <div class="relative" style="width:540px; height:660px; transform:scale(0.75); transform-origin: top center;">
                    <template x-for="tooth in [18,17,16,15,14,13,12,11,21,22,23,24,25,26,27,28,48,47,46,45,44,43,42,41,31,32,33,34,35,36,37,38,55,54,53,52,51,61,62,63,64,65,85,84,83,82,81,71,72,73,74,75]" :key="tooth">
                        <div>
                            <div class="text-xs font-bold text-gray-800 flex justify-center items-center w-6 h-6" :style="getPrintNumberStyle(tooth)">
                                <span x-text="tooth"></span>
                            </div>
                            <div :class="isAdultTooth(tooth) ? 'w-10 h-10' : 'w-7 h-7'" :style="getPrintArchStyle(tooth)">
                                <div x-html="renderToothInteractive(tooth)"></div>
                            </div>
                        </div>
                    </template>
                    <div style="position:absolute;left:50%;top:16px;transform:translateX(-50%)" class="text-blue-900 font-bold text-base uppercase tracking-widest">Adulte</div>
                    <div style="position:absolute;left:50%;top:56px;transform:translateX(-50%)" class="text-blue-900 font-bold text-xs uppercase">HAUT</div>
                    <div style="position:absolute;left:50%;top:50%;transform:translate(-50%,-50%)" class="text-blue-900 font-bold uppercase border-2 border-blue-900 px-2 py-0.5 rounded bg-white z-10 text-xs">Enfant</div>
                    <div style="position:absolute;left:50%;bottom:56px;transform:translateX(-50%)" class="text-blue-900 font-bold text-xs uppercase">BAS</div>
                    <div style="position:absolute;left:0;top:50%;transform:translateY(-50%)" class="text-blue-900 font-bold text-xs uppercase">DROITE</div>
                    <div style="position:absolute;right:0;top:50%;transform:translateY(-50%)" class="text-blue-900 font-bold text-xs uppercase">GAUCHE</div>
                </div>
            </div>

            {{-- Table --}}
            <div class="print-table-area">
                <table class="print-table">
                    <thead>
                        <tr>
                            <th class="w-[15%]">DATES</th>
                            <th class="w-[40%]">NATURES DES OPÉRATIONS</th>
                            <th class="w-[15%]">PRIX CONVENU</th>
                            <th class="w-[15%]">REÇU</th>
                            <th class="w-[15%]">A RECEVOIR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(group, i) in getGroupedTreatments()" :key="i">
                            <tr>
                                <td class="text-center">{{ date('d/m/y') }}</td>
                                <td class="font-bold">
                                    <span x-text="group.description"></span><br>
                                    <span class="text-xs text-gray-500 font-normal">Dents: <span x-text="group.teeth.join(', ')"></span></span>
                                </td>
                                <td class="text-right" x-text="formatPrice(group.totalPrice)"></td>
                                <td class="text-right" x-text="formatPrice(group.totalReceived)"></td>
                                <td class="text-right font-bold" x-text="formatPrice(group.totalPrice - group.totalReceived)"></td>
                            </tr>
                        </template>
                        <template x-for="i in Math.max(0, 8 - getGroupedTreatments().length)" :key="'empty-'+i">
                            <tr style="height:28px"><td></td><td></td><td></td><td></td><td></td></tr>
                        </template>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="font-black text-center">A REPORTER</td>
                            <td class="text-right font-bold" x-text="formatPrice(calculateTotal())"></td>
                            <td class="text-right font-bold" x-text="formatPrice(calculateReceived())"></td>
                            <td class="text-right font-black" x-text="formatPrice(calculateTotal() - calculateReceived())"></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="flex justify-between items-end mt-8">
                    <p class="text-xs text-gray-400">Document généré le {{ date('d/m/Y H:i') }}</p>
                    <div class="border-t-2 border-black pt-1 w-48 text-center text-xs font-bold">Cachet & Signature</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('odontogram', () => ({
                treatmentCatalogs: @json($treatmentCatalogs),
                chartData: {},
                isSaving: false,
                isChild: @json($isChild),
                canEditChart: false,
                findings: @json($findings),

                init() {
                    const allTeeth = [18,17,16,15,14,13,12,11,21,22,23,24,25,26,27,28,48,47,46,45,44,43,42,41,31,32,33,34,35,36,37,38,55,54,53,52,51,61,62,63,64,65,85,84,83,82,81,71,72,73,74,75];
                    allTeeth.forEach(t => {
                        this.chartData[t] = { status: 'healthy', surfaces: { T:'healthy', R:'healthy', B:'healthy', L:'healthy', C:'healthy' }, treatments: [], received: 0 };
                    });
                    if (this.findings?.length) {
                        this.findings.forEach(f => {
                            if (this.chartData[f.tooth_number]) {
                                this.chartData[f.tooth_number].status = f.status;
                                if (f.surfaces) this.chartData[f.tooth_number].surfaces = f.surfaces;
                                if (f.treatments?.length) this.chartData[f.tooth_number].treatments = f.treatments;
                                this.chartData[f.tooth_number].received = parseFloat(f.received || 0);
                                this.chartData[f.tooth_number].price = parseFloat(f.price || 0);
                            }
                        });
                    }
                },

                isToothAffected(tooth) {
                    if (!this.chartData[tooth]) return false;
                    let d = this.chartData[tooth];
                    if (d.status !== 'healthy') return true;
                    if (d.treatments.length > 0) return true;
                    return Object.values(d.surfaces).some(s => s !== 'healthy');
                },
                hasFindings() { return Object.keys(this.chartData).some(t => this.isToothAffected(t)); },
                getTreatmentDescription(tooth) {
                    let d = this.chartData[tooth]; if (!d) return '';
                    let parts = [];
                    if (d.status === 'extracted') parts.push('Extraction');
                    if (d.status === 'crown') parts.push('Crown');
                    if (d.status === 'decayed') parts.push('Decayed');
                    for (let s in d.surfaces) { if (d.surfaces[s]==='decayed') parts.push(`Caries(${s})`); if (d.surfaces[s]==='filled') parts.push(`Filling(${s})`); }
                    if (d.treatments) d.treatments.forEach(t => parts.push(t.name));
                    return parts.join(', ');
                },
                getGroupedTreatments() {
                    const groups = {};
                    for (const tooth in this.chartData) {
                        if (this.isToothAffected(tooth)) {
                            let price = 0;
                            this.chartData[tooth].treatments.forEach(t => price += parseFloat(t.price || 0));
                            if (!price) price = parseFloat(this.chartData[tooth].price || 0);
                            const desc = this.getTreatmentDescription(tooth) || 'Consultation';
                            if (!groups[desc]) groups[desc] = { description: desc, teeth: [], totalPrice: 0, totalReceived: 0 };
                            groups[desc].teeth.push(tooth);
                            groups[desc].totalPrice += price;
                            groups[desc].totalReceived += parseFloat(this.chartData[tooth].received || 0);
                        }
                    }
                    return Object.values(groups);
                },
                calculateTotal() { let t = 0; for (const tooth in this.chartData) { if (this.isToothAffected(tooth)) { this.chartData[tooth].treatments.forEach(tr => t += parseFloat(tr.price||0)); if (!this.chartData[tooth].treatments.length) t += parseFloat(this.chartData[tooth].price||0); } } return t; },
                calculateReceived() { let t = 0; for (const tooth in this.chartData) { if (this.isToothAffected(tooth)) t += parseFloat(this.chartData[tooth].received||0); } return t; },
                formatPrice(p) { return (parseFloat(p)||0).toLocaleString('en-US',{minimumFractionDigits:2,maximumFractionDigits:2})+' DH'; },
                getSurfaceColor(tooth, surface) {
                    let d = this.chartData[tooth]; if (!d) return '#fff';
                    if (d.status==='extracted') return 'none';
                    if (d.status==='crown') return '#fef08a';
                    let s = d.surfaces[surface];
                    if (s==='decayed') return '#ef4444';
                    if (s==='filled') return '#3b82f6';
                    return '#fff';
                },
                getToothStroke(tooth) {
                    let d = this.chartData[tooth]; if (!d) return '#d1d5db';
                    if (d.status==='extracted') return 'none';
                    if (d.status==='crown') return '#ca8a04';
                    return '#9ca3af';
                },
                renderToothInteractive(tooth) {
                    if (!tooth) return '';
                    let d = this.chartData[tooth];
                    let stroke = this.getToothStroke(tooth);
                    let cT=this.getSurfaceColor(tooth,'T'),cR=this.getSurfaceColor(tooth,'R'),cB=this.getSurfaceColor(tooth,'B'),cL=this.getSurfaceColor(tooth,'L'),cC=this.getSurfaceColor(tooth,'C');
                    if (d?.status==='extracted') return `<svg viewBox="0 0 40 40" class="w-full h-full"><line x1="5" y1="5" x2="35" y2="35" stroke="#ef4444" stroke-width="3" stroke-linecap="round"/><line x1="35" y1="5" x2="5" y2="35" stroke="#ef4444" stroke-width="3" stroke-linecap="round"/></svg>`;
                    return `<svg viewBox="0 0 40 40" class="w-full h-full"><polygon points="20,2 38,20 20,38 2,20" fill="${cT}" stroke="${stroke}" stroke-width="1"/><polygon points="20,10 30,20 20,30 10,20" fill="${cC}" stroke="${stroke}" stroke-width="1"/><polygon points="38,20 30,20 20,30 20,38" fill="${cR}" stroke="${stroke}" stroke-width="1"/><polygon points="2,20 10,20 20,30 20,38" fill="${cL}" stroke="${stroke}" stroke-width="1"/></svg>`;
                },
                isAdultTooth(tooth) { let t=parseInt(tooth); return t>=11&&t<=48; },
                isUpperTooth(tooth) { let t=parseInt(tooth); return (t>=11&&t<=28)||(t>=51&&t<=65); },
                getPrintArchStyle(tooth) {
                    let t=parseInt(tooth),isUpper=false,isAdult=true,index=0,isLeftQuad=false;
                    if(t>=11&&t<=18){isUpper=true;isAdult=true;index=t-11;isLeftQuad=true;}
                    if(t>=21&&t<=28){isUpper=true;isAdult=true;index=t-21;}
                    if(t>=41&&t<=48){isUpper=false;isAdult=true;index=t-41;isLeftQuad=true;}
                    if(t>=31&&t<=38){isUpper=false;isAdult=true;index=t-31;}
                    if(t>=51&&t<=55){isUpper=true;isAdult=false;index=t-51;isLeftQuad=true;}
                    if(t>=61&&t<=65){isUpper=true;isAdult=false;index=t-61;}
                    if(t>=81&&t<=85){isUpper=false;isAdult=false;index=t-81;isLeftQuad=true;}
                    if(t>=71&&t<=75){isUpper=false;isAdult=false;index=t-71;}
                    let totalTeeth=isAdult?8.2:5.2;
                    let angleRad=((index+0.5)/totalTeeth)*(Math.PI/2);
                    if(isLeftQuad)angleRad=-angleRad;
                    let rx=isAdult?180:100,ry=isAdult?220:120;
                    let x=Math.sin(angleRad)*rx,y=Math.cos(angleRad)*ry;
                    if(isUpper)y=-y;
                    y+=isUpper?-30:30;
                    return `position:absolute;left:50%;top:50%;transform:translate(-50%,-50%) translate(${x}px,${y}px);`;
                },
                getPrintNumberStyle(tooth) {
                    let t=parseInt(tooth),isUpper=false,isAdult=true,index=0,isLeftQuad=false;
                    if(t>=11&&t<=18){isUpper=true;isAdult=true;index=t-11;isLeftQuad=true;}
                    if(t>=21&&t<=28){isUpper=true;isAdult=true;index=t-21;}
                    if(t>=41&&t<=48){isUpper=false;isAdult=true;index=t-41;isLeftQuad=true;}
                    if(t>=31&&t<=38){isUpper=false;isAdult=true;index=t-31;}
                    if(t>=51&&t<=55){isUpper=true;isAdult=false;index=t-51;isLeftQuad=true;}
                    if(t>=61&&t<=65){isUpper=true;isAdult=false;index=t-61;}
                    if(t>=81&&t<=85){isUpper=false;isAdult=false;index=t-81;isLeftQuad=true;}
                    if(t>=71&&t<=75){isUpper=false;isAdult=false;index=t-71;}
                    let totalTeeth=isAdult?8.2:5.2;
                    let angleRad=((index+0.5)/totalTeeth)*(Math.PI/2);
                    if(isLeftQuad)angleRad=-angleRad;
                    let offset=isAdult?40:25;
                    let rx=(isAdult?180:100)+offset,ry=(isAdult?220:120)+offset;
                    let x=Math.sin(angleRad)*rx,y=Math.cos(angleRad)*ry;
                    if(isUpper)y=-y;
                    y+=isUpper?-30:30;
                    return `position:absolute;left:50%;top:50%;transform:translate(-50%,-50%) translate(${x}px,${y}px);`;
                },
            }));
        });
    </script>
</body>
</html>
