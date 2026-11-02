(function () {
  var cells = '';
  for (var i = 0; i < 30; i++) cells += '<i style="--d:' + (((i * 7) % 30) * 42) + 'ms"></i>';
  window.AT = {
    label: 'Laporan_Mahasiswa.xlsx',
    ms: 1600,
    intro: '<div class="xl-boot">' + cells + '</div>'
  };
})();
