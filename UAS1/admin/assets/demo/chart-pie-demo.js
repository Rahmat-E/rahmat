const ctx3 = document.getElementById('myPieChart');


new Chart(ctx3, {
  type: 'pie',
  data: {
    labels: ['Wine', 'Beer', 'Coke', 'Soda'],
    datasets: [{
      label: '# of Colors',
      data: [12, 19, 3, 5],

    }]
  },
  
});
