        <!-- ========================================== -->
        <!--              DEDICATED PRINT VIEW            -->
        <!-- ========================================== -->
        <div id="print-area" class="{{ isset($isPortal) && $isPortal ? 'flex flex-col' : 'hidden print:flex' }} text-black">
            <!-- Header -->
            <div class="print-header-area w-full">
                @php
                    $org = auth()->user()->organization;
                    $logoUrl = $org && $org->logo ? Storage::url($org->logo) : null;
                @endphp
                <div class="w-1/2 flex items-start gap-4">
                    @if($logoUrl)
                        <img src="{{ $logoUrl }}" alt="Clinic Logo" class="max-h-16 w-24 object-contain">
                    @endif
                    @if(!isset($isPortal) || !$isPortal)
                    <div>
                        <h1 class="text-2xl font-black text-black tracking-tight leading-none mb-1 uppercase">{{ $org ? $org->name : 'DENTAL CLINIC' }}</h1>
                        <p class="text-[10px] text-gray-600 leading-tight w-48">{{ $org ? $org->address : '' }}</p>
                        <p class="text-[10px] text-gray-600 leading-tight mb-2">{{ $org && $org->phone ? 'Tel: ' . $org->phone : '' }}</p>
                        <p class="text-[13px] text-gray-800 font-bold">Dr. __________________</p>
                    </div>
                    @endif
                </div>
                <div class="w-1/2 text-right text-[11px] leading-snug">
                    <p><strong>Patient:</strong> {{ $patient->first_name }} {{ $patient->last_name }}</p>
                    <p><strong>Age:</strong> {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} Ans &nbsp;|&nbsp; <strong>Tel:</strong> {{ $patient->phone ?? '..................' }}</p>
                    <p><strong>CNSS / Mutuelle:</strong> ......................................</p>
                    <p><strong>Date:</strong> {{ date('d/m/Y') }}</p>
                </div>
            </div>

            <!-- Body -->
            <div class="print-body-area w-full">
                
                <!-- Left: Chart -->
                <div class="print-chart-area pt-2">
                    <div class="{{ isset($isPortal) && $isPortal ? 'chart-wrapper' : '' }}" style="{{ !isset($isPortal) || !$isPortal ? 'width: 100%; transform: scale(0.85); transform-origin: top center; display: flex; justify-content: center;' : '' }}">
                        <div class="relative mt-4 {{ isset($isPortal) && $isPortal ? 'chart-scaler' : '' }}" style="{{ !isset($isPortal) || !$isPortal ? 'width: 600px; height: 700px;' : '' }}">
                            <template x-for="tooth in [18,17,16,15,14,13,12,11, 21,22,23,24,25,26,27,28, 48,47,46,45,44,43,42,41, 31,32,33,34,35,36,37,38, 55,54,53,52,51, 61,62,63,64,65, 85,84,83,82,81, 71,72,73,74,75]" :key="tooth">
                                <div>
                                    <!-- Number Label -->
                                    <div class="text-[12px] font-bold text-gray-800 flex justify-center items-center w-6 h-6" :style="getPrintNumberStyle(tooth)">
                                        <span x-text="tooth"></span>
                                    </div>
                                    <!-- Tooth Render -->
                                    <div :class="isAdultTooth(tooth) ? 'w-10 h-10' : 'w-7 h-7'" :style="getPrintArchStyle(tooth)">
                                        <div x-html="renderToothInteractive(tooth)"></div>
                                    </div>
                                </div>
                            </template>
                            
                            <!-- Center Labels -->
                            <div style="position: absolute; left: 50%; top: 16px; transform: translateX(-50%);" class="text-blue-900 font-bold text-lg uppercase tracking-widest">Adulte</div>
                            <div style="position: absolute; left: 50%; top: 64px; transform: translateX(-50%);" class="text-blue-900 font-bold text-sm uppercase">HAUT</div>
                            
                            <div style="position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);" class="text-blue-900 font-bold uppercase border-2 border-blue-900 px-3 py-1 rounded shadow-sm bg-white z-10">Enfant</div>
                            
                            <div style="position: absolute; left: 50%; bottom: 64px; transform: translateX(-50%);" class="text-blue-900 font-bold text-sm uppercase">BAS</div>
                            
                            <!-- Side Labels -->
                            <div style="position: absolute; left: 0; top: 50%; transform: translateY(-50%);" class="text-blue-900 font-bold text-sm uppercase">DROITE</div>
                            <div style="position: absolute; right: 0; top: 50%; transform: translateY(-50%);" class="text-blue-900 font-bold text-sm uppercase">GAUCHE</div>
                        </div>
                    </div>
                </div>

                <!-- Right: Table -->
                <div class="print-table-area pt-2">
                    <table class="print-table w-full text-black">
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
                            <!-- Grouped Rows -->
                            <template x-for="(group, index) in getGroupedTreatments()" :key="index">
                                <tr>
                                    <td class="text-center font-medium">{{ date('d/m/y') }}</td>
                                    <td class="font-bold">
                                        <span x-text="group.description"></span>
                                        <br>
                                        <span class="text-[10px] text-gray-600 font-normal">Dents: <span x-text="group.teeth.join(', ')"></span></span>
                                    </td>
                                    <td class="text-right font-medium" x-text="formatPrice(group.totalPrice)"></td>
                                    <td class="text-right font-medium" x-text="formatPrice(group.totalReceived)"></td>
                                    <td class="text-right font-bold text-black" x-text="formatPrice(group.totalPrice - group.totalReceived)"></td>
                                </tr>
                            </template>

                            <!-- Empty Rows (Padding) -->
                            <template x-if="!hasFindings()">
                                <template x-for="i in 10">
                                    <tr class="h-[30px]">
                                        <td></td><td></td><td></td><td></td><td></td>
                                    </tr>
                                </template>
                            </template>
                            <template x-if="hasFindings()">
                                <template x-for="i in Math.max(0, 5 - getGroupedTreatments().length)">
                                    <tr class="h-[30px]">
                                        <td></td><td></td><td></td><td></td><td></td>
                                    </tr>
                                </template>
                            </template>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="font-black text-center text-[12px]">A REPORTER</td>
                                <td class="text-right font-bold" x-text="formatPrice(calculateTotal())"></td>
                                <td class="text-right font-bold" x-text="formatPrice(calculateReceived())"></td>
                                <td class="text-right font-black text-[13px]" x-text="formatPrice(calculateTotal() - calculateReceived())"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
            
            <!-- Footer Signature Space -->
            <div class="w-full flex justify-between items-end pt-4 mt-auto">
                <div class="text-[10px] text-gray-500 font-medium">Document généré le {{ date('d/m/Y H:i') }}</div>
                @if(!isset($isPortal) || !$isPortal)
                <div class="text-[12px] font-bold text-black border-t-2 border-black pt-1 w-48 text-center">Cachet & Signature</div>
                @endif
            </div>
        </div>

