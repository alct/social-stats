
// identities menu

$('#identities ul').hide();

$('#identities p .current').on('focus', function() {
  $('#identities ul').show();
});

$('#identities p .current').on('keydown', function(e) {
  if (e.keyCode == 9) {
    $('#identities ul').addClass('tab');
  }
});

$('#identities ul').on('mouseover', function() {
  $('#identities ul').addClass('mouse');
});

$('#identities ul').on('mouseout', function() {
  $('#identities ul').removeClass('mouse').removeClass('tab');
});

$('#identities ul li:last-child a').on('blur', function() {
  if ($('#identities ul').hasClass('tab')) {
    $('#identities ul').hide().removeClass('tab');
  }
});

$('#identities p .current').on('blur', function() {
  if (!$('#identities ul').is('.tab, .mouse')) {
    $('#identities ul').hide();
  }
});

// toggle buttons (period, scale)

function toggleButton(el) {
  el.parent().children().removeClass('current');
  el.addClass('current');

  if (el.parent().attr('id') == 'scale') {
    var scale = el.text() == 'Linear' ? 0 : 1;
    g.updateOptions({ logscale: scale });
  } else if (el.parent().attr('id') == 'period') {
    var
      date        = new Date(),
      firstDay    = new Date(date.getFullYear(), date.getMonth(), 1),
      currentDay  = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    if (el.text() == 'Current month') {
      zoomGraphX(firstDay, currentDay);
    } else {
      unzoomGraph();
    }
  }
}

$('#options .button').on('click', function() {
  toggleButton($(this));
});

$('#options .button').on('keydown', function(e) {
  if (e.keyCode == 13 || e.keyCode == 32) {
    toggleButton($(this));
  }
});

// display/hide peculiar data

function toggleData(el) {
  g.setVisibility(el.attr('value'), el.is(':checked') ? 1 : 0);
}

$('#options input').on('click', function() {
  toggleData($(this));
});

// tab navigation

function setCurrentTab() {
  var frag = window.location.href.split('#');

  if (frag.length == 1) {
    $('#nav ul').children().removeClass('current');
    $('#nav a[href=#dashboard]').parent().addClass('current');
  } else if (!frag[1].length) {
    // if the hash is empty, do nothing
  } else {
    $('#nav ul').children().removeClass('current');
    $('#nav a[href=' + window.location.hash + ']').parent().addClass('current');
  }
}

function setCurrentOptions() {
  var hash = window.location.hash;

  if (hash == '#dashboard') {
    $('#options div').show().removeClass('hidden');
  } else if (hash == '#twitter' || hash == '#identica' || hash == '#facebook') {
    $('#options .network').hide().addClass('hidden');
    $('#options div').filter('.' + hash.substring(1)).show().removeClass('hidden');
  }
}

// update the graph (axes, data)

function setCurrentGraph() {
  var el = window.location.hash.substring(1);

  if (el == 'twitter') {
    g.updateOptions({
      visibility: [true, true, false, false, false, ],
      series: {
        'Twitter followers'  :  { axis: 'y' },
        'Twitter tweets'     :  { axis: 'y2' },
        'Identica followers' :  { axis: 'y' },
        'Identica notices'   :  { axis: 'y' },
        'Facebook likes'     :  { axis: 'y' },
      },
    });
  } else if (el == 'identica') {
    g.updateOptions({
      visibility: [false, false, true, true, false, ],
      series: {
        'Twitter followers'  :  { axis: 'y' },
        'Twitter tweets'     :  { axis: 'y' },
        'Identica followers' :  { axis: 'y' },
        'Identica notices'   :  { axis: 'y2' },
        'Facebook likes'     :  { axis: 'y' },
      },
    });
  } else if (el == 'facebook') {
    g.updateOptions({
      visibility: [false, false, false, false, true, ],
      series: {
        'Twitter followers'  :  { axis: 'y' },
        'Twitter tweets'     :  { axis: 'y' },
        'Identica followers' :  { axis: 'y' },
        'Identica notices'   :  { axis: 'y' },
        'Facebook likes'     :  { axis: 'y' },
      },
    });
  } else if (el == 'dashboard') {
    g.updateOptions({
      visibility: [true, true, true, true, true, ],
      series: {
        'Twitter followers'  :  { axis: 'y' },
        'Twitter tweets'     :  { axis: 'y' },
        'Identica followers' :  { axis: 'y' },
        'Identica notices'   :  { axis: 'y' },
        'Facebook likes'     :  { axis: 'y' },
      },
    });
  }
}

// dygraph

g = new Dygraph(
  document.getElementById('graph'),
  localLog,
  {
    width: 910,
    height: 420,
    colors: ['#13a7dd', '#fdb524', '#8dc500', '#fb6104', '#3b5998'],
    labelsSeparateLines: true,
    labelsDivStyles: {
      'padding': '10px 15px',
      'backgroundColor': 'rgba(255, 255, 255, .85)',
    },
    visibility: graphVisibility,
    series: {
      'Twitter followers'  :  { axis: 'y' },
      'Twitter tweets'     :  { axis: 'y' },
      'Identica followers' :  { axis: 'y' },
      'Identica notices'   :  { axis: 'y' },
      'Facebook likes'     :  { axis: 'y' },
    },
    axes: {
      y: {
        axisLabelFormatter: function(y) {
          return Math.round(y);
        }
      },
      y2: {
        axisLabelFormatter: function(y) {
          return Math.round(y);
        }
      }
    }
  }
);

// zoom functions

function zoomGraphX(minDate, maxDate) {
  g.updateOptions({
    dateWindow: [Date.parse(minDate), Date.parse(maxDate)]
  });
}

function unzoomGraph() {
  g.updateOptions({
    dateWindow: null
  });
}

// initiate the graph and handle tab change

$(window).on('load', function() {
  setCurrentOptions();
  setCurrentTab();
  setCurrentGraph();
});

$(window).on('hashchange', function() {
  setCurrentOptions();
  setCurrentTab();
  setCurrentGraph();
});