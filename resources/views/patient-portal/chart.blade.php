@extends('layouts.patient')

@section('content')
<style>
    /* Print Layout Styles */
    .print-body-area{display: flex; flex-direction: row; flex: 1 1 auto; flex-wrap: wrap;} 
    .print-chart-area{width: 45%; display: flex; flex-direction: column; align-items: center; justify-content: flex-start; padding-right: 15px;} 
    .print-table-area{width: 55%; padding-left: 15px; display: flex; flex-direction: column; border-left: 2px solid #e5e7eb;} 
    .print-table{width: 100%; border-collapse: collapse; font-size: 12px; color: black;} 
    .print-table th, .print-table td{border: 1px solid #e5e7eb; padding: 10px; text-align: left; color: #374151;} 
    .print-table th{background-color: #f9fafb !important; font-weight: bold; color: #111827;}
    
    .chart-wrapper {
        --scale: 0.85;
        width: calc(600px * var(--scale));
        height: calc(700px * var(--scale));
        margin: 0 auto;
        overflow: hidden;
    }
    
    .chart-scaler {
        width: 600px;
        height: 700px;
        transform: scale(var(--scale));
        transform-origin: top left;
    }

    @media (max-width: 1024px) {
        .print-body-area { flex-direction: column; }
        .print-chart-area { width: 100%; padding-right: 0; padding-bottom: 20px; }
        .print-table-area { width: 100%; border-left: none; border-top: 2px solid #e5e7eb; padding-left: 0; padding-top: 20px; }
    }
    @media (max-width: 768px) {
        .print-header-area { flex-direction: column; align-items: center; text-align: center; gap: 1rem; }
        .print-header-area > div { width: 100% !important; justify-content: center; align-items: center; }
        .print-header-area > div.text-right { text-align: center !important; }
        .chart-wrapper { --scale: 0.7; }
    }
    @media (max-width: 480px) {
        .chart-wrapper { --scale: 0.55; }
    }
</style>

<div class="space-y-4 sm:space-y-8" x-data="patientChart()">
    <div class="bg-white rounded-xl sm:rounded-3xl p-4 sm:p-8 shadow-sm border border-gray-100">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">My Dental Chart</h2>
        <p class="text-sm sm:text-base text-gray-500 mb-6">Here is an overview of your treatments and billing progress.</p>
        
        <div class="w-full">
            @include('patients.partials.odontogram-print', ['isPortal' => true])
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('patientChart', () => ({
            findings: @json($findings),
            isChild: @json($isChild ?? false),
            chartData: {},
            
            init() {
                const allTeeth = [
                    18,17,16,15,14,13,12,11, 21,22,23,24,25,26,27,28,
                    48,47,46,45,44,43,42,41, 31,32,33,34,35,36,37,38,
                    55,54,53,52,51, 61,62,63,64,65,
                    85,84,83,82,81, 71,72,73,74,75
                ];
                
                allTeeth.forEach(t => {
                    this.chartData[t] = {
                        status: 'healthy',
                        surfaces: { T: 'healthy', R: 'healthy', B: 'healthy', L: 'healthy', C: 'healthy' },
                        treatments: [],
                        received: 0
                    };
                });
                
                if (this.findings && this.findings.length > 0) {
                    this.findings.forEach(f => {
                        if (this.chartData[f.tooth_number]) {
                            this.chartData[f.tooth_number].status = f.status;
                            if (f.surfaces) this.chartData[f.tooth_number].surfaces = f.surfaces;
                            if (f.treatments && Array.isArray(f.treatments)) {
                                this.chartData[f.tooth_number].treatments = f.treatments;
                            } else {
                                let price = f.price ? parseFloat(f.price) : 0;
                                if (price > 0) {
                                    this.chartData[f.tooth_number].treatments.push({
                                        id: null,
                                        name: 'Legacy Treatment',
                                        price: price
                                    });
                                }
                            }
                            this.chartData[f.tooth_number].received = f.received ? parseFloat(f.received) : 0;
                        }
                    });
                }
            },
            
            getPrintArchStyle(tooth) {
                let t = parseInt(tooth);
                let isUpper = false;
                let isAdult = true;
                let index = 0; 
                let isLeftQuad = false; 
                if(t >= 11 && t <= 18) { isUpper = true; isAdult = true; index = t - 11; isLeftQuad = true; } 
                if(t >= 21 && t <= 28) { isUpper = true; isAdult = true; index = t - 21; isLeftQuad = false; } 
                if(t >= 41 && t <= 48) { isUpper = false; isAdult = true; index = t - 41; isLeftQuad = true; }
                if(t >= 31 && t <= 38) { isUpper = false; isAdult = true; index = t - 31; isLeftQuad = false; }
                if(t >= 51 && t <= 55) { isUpper = true; isAdult = false; index = t - 51; isLeftQuad = true; }
                if(t >= 61 && t <= 65) { isUpper = true; isAdult = false; index = t - 61; isLeftQuad = false; }
                if(t >= 81 && t <= 85) { isUpper = false; isAdult = false; index = t - 81; isLeftQuad = true; }
                if(t >= 71 && t <= 75) { isUpper = false; isAdult = false; index = t - 71; isLeftQuad = false; }
                let totalTeeth = isAdult ? 8.2 : 5.2; 
                let angleProgress = (index + 0.5) / totalTeeth; 
                let angleRad = angleProgress * (Math.PI / 2); 
                if (isLeftQuad) angleRad = -angleRad; 
                let rx = isAdult ? 180 : 100;
                let ry = isAdult ? 220 : 120;
                let x = Math.sin(angleRad) * rx;
                let y = Math.cos(angleRad) * ry; 
                if (isUpper) y = -y;
                let originY = isUpper ? -30 : 30; 
                y = y + originY;
                return `position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%) translate(${x}px, ${y}px);`;
            },
            
            getPrintNumberStyle(tooth) {
                let t = parseInt(tooth);
                let isUpper = false;
                let isAdult = true;
                let index = 0; 
                let isLeftQuad = false; 
                if(t >= 11 && t <= 18) { isUpper = true; isAdult = true; index = t - 11; isLeftQuad = true; } 
                if(t >= 21 && t <= 28) { isUpper = true; isAdult = true; index = t - 21; isLeftQuad = false; } 
                if(t >= 41 && t <= 48) { isUpper = false; isAdult = true; index = t - 41; isLeftQuad = true; }
                if(t >= 31 && t <= 38) { isUpper = false; isAdult = true; index = t - 31; isLeftQuad = false; }
                if(t >= 51 && t <= 55) { isUpper = true; isAdult = false; index = t - 51; isLeftQuad = true; }
                if(t >= 61 && t <= 65) { isUpper = true; isAdult = false; index = t - 61; isLeftQuad = false; }
                if(t >= 81 && t <= 85) { isUpper = false; isAdult = false; index = t - 81; isLeftQuad = true; }
                if(t >= 71 && t <= 75) { isUpper = false; isAdult = false; index = t - 71; isLeftQuad = false; }
                let totalTeeth = isAdult ? 8.2 : 5.2; 
                let angleProgress = (index + 0.5) / totalTeeth; 
                let angleRad = angleProgress * (Math.PI / 2); 
                if (isLeftQuad) angleRad = -angleRad; 
                let offset = isAdult ? 40 : 25;
                let rx = (isAdult ? 180 : 100) + offset;
                let ry = (isAdult ? 220 : 120) + offset;
                let x = Math.sin(angleRad) * rx;
                let y = Math.cos(angleRad) * ry; 
                if (isUpper) y = -y;
                let originY = isUpper ? -30 : 30; 
                y = y + originY;
                return `position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%) translate(${x}px, ${y}px);`;
            },
            
            isUpperTooth(tooth) { let t = parseInt(tooth); return (t >= 11 && t <= 28) || (t >= 51 && t <= 65); },
            isAdultTooth(tooth) { let t = parseInt(tooth); return (t >= 11 && t <= 48); },
            
            getGroupedTreatments() {
                let groups = {};
                for(let tooth in this.chartData) {
                    let data = this.chartData[tooth];
                    if (data.treatments && data.treatments.length > 0) {
                        data.treatments.forEach(tr => {
                            let key = tr.name;
                            if(!groups[key]) { groups[key] = { description: key, teeth: [], totalPrice: 0, totalReceived: 0 }; }
                            if(!groups[key].teeth.includes(tooth)) { groups[key].teeth.push(tooth); }
                            let price = parseFloat(tr.price) || 0;
                            groups[key].totalPrice += price;
                        });
                        let rec = parseFloat(data.received) || 0;
                        if(rec > 0) {
                            let key = data.treatments[0].name;
                            groups[key].totalReceived += rec;
                        }
                    }
                }
                return Object.values(groups).sort((a,b) => b.totalPrice - a.totalPrice);
            },
            
            hasFindings() { return this.getGroupedTreatments().length > 0; },
            
            calculateTotal() {
                let total = 0;
                for(let tooth in this.chartData) {
                    let data = this.chartData[tooth];
                    if (data.treatments) {
                        data.treatments.forEach(tr => { total += (parseFloat(tr.price) || 0); });
                    }
                }
                return total;
            },
            
            calculateReceived() {
                let total = 0;
                for(let tooth in this.chartData) {
                    let rec = parseFloat(this.chartData[tooth].received) || 0;
                    total += rec;
                }
                return total;
            },
            
            formatPrice(price) { return (parseFloat(price) || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' DH'; },
            
            renderToothInteractive(tooth) {
                let data = this.chartData[tooth] || { status: 'healthy', surfaces: {T:'healthy',R:'healthy',B:'healthy',L:'healthy',C:'healthy'} };
                let hasTreatments = data.treatments && data.treatments.length > 0;
                let getColor = (status) => {
                    if(status === 'caries') return '#ef4444';
                    if(status === 'filling') return '#3b82f6';
                    if(status === 'crown') return '#eab308';
                    return '#ffffff';
                };
                let cT = getColor(data.surfaces.T);
                let cR = getColor(data.surfaces.R);
                let cB = getColor(data.surfaces.B);
                let cL = getColor(data.surfaces.L);
                let cC = getColor(data.surfaces.C);
                let stroke = data.status === 'crown' ? '#eab308' : '#94a3b8';
                
                let svg = `<svg viewBox="0 0 100 100" class="w-full h-full drop-shadow-sm">`;
                if(data.status === 'missing' || data.status === 'extracted') {
                    svg += `<rect x="0" y="0" width="100" height="100" fill="transparent"/>
                            <line x1="10" y1="10" x2="90" y2="90" stroke="#9ca3af" stroke-width="8" stroke-linecap="round" class="pointer-events-none"/>
                            <line x1="90" y1="10" x2="10" y2="90" stroke="#9ca3af" stroke-width="8" stroke-linecap="round" class="pointer-events-none"/>`;
                } else {
                    svg += `<circle cx="50" cy="50" r="48" fill="#ffffff" stroke="${stroke}" stroke-width="3" class="pointer-events-none"/>
                            <polygon points="15,15 85,15 65,35 35,35" fill="${cT}" stroke="${stroke}" stroke-width="2"/>
                            <polygon points="85,15 85,85 65,65 65,35" fill="${cR}" stroke="${stroke}" stroke-width="2"/>
                            <polygon points="15,85 85,85 65,65 35,65" fill="${cB}" stroke="${stroke}" stroke-width="2"/>
                            <polygon points="15,15 15,85 35,65 35,35" fill="${cL}" stroke="${stroke}" stroke-width="2"/>
                            <rect x="35" y="35" width="30" height="30" fill="${cC}" stroke="${stroke}" stroke-width="2"/>`;
                }
                if(hasTreatments) {
                    svg += `<circle cx="85" cy="15" r="12" fill="#39D3C4" stroke="#ffffff" stroke-width="2" class="pointer-events-none"/>`;
                }
                svg += `</svg>`;
                return svg;
            }
        }));
    });
</script>
@endsection
