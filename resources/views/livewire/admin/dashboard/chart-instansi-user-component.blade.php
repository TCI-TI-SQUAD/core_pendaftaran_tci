<div class="col-12 col-xl-4 d-flex justify-content-center mt-3">
    <div class="container">
        <div class="row overflow-auto justify-content-center">
            <div class="col-12">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <a href="" id="download" class="btn btn-block btn-info" download="chart.png">DOWNLOAD CHART</a>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
        document.addEventListener('livewire:load', function () {
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Umum', 'Siswa', 'Mahasiswa', 'Instansi'],
                    datasets: [{
                        label: 'Asal Status User',
                        data: {{ $dataset }},
                        backgroundColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                            }
                        }],
                    yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                                steps: 10,
                                stepValue: 5,
                                suggestedMax:{{ max(json_decode($dataset))+10 }},
                            }
                        }]
                    },
                    animation: {
                        onComplete: function() {
                            $("#download").toggleClass('d-block');
                            $("#download").attr("href",myChart.toBase64Image());
                        }
                    }
                }
            });

        })
</script>
@endpush
