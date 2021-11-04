<?php
include '/var/www/includes/glpa2021.php'; // glpa 2021 custom code (to pull in schedule)
$data = schedule_data_2021(); // returns hashmap with tz (timezone), start_str (starting date used to figure out DST or not and year), schedule_types (not needed for our use), and schedule (decoded JSON object containing the full schedule)

date_default_timezone_set('US/'. $data['tz']);
$start_time = strtotime($data['start_str']);

// print '<pre>'; print_r($data['schedule']); print '</pre>';

$nonstreamed_events = FALSE;
$schedule_by_day = array();
foreach ($data['schedule'] as $event) {
  if (!$event['Live?']) {
    continue; // skip events which aren't live-streamed
  }
  if ($event['Disable?']) {
    continue; // skip events which are disabled
  }
  if (!array_key_exists($event['Date'], $schedule_by_day)) {
    $schedule_by_day[$event['Date']] = array(); // create empty index for this day, if it doesn't already exist
  }
  if (!array_key_exists($event['Start Time'], $schedule_by_day[$event['Date']])) {
    $schedule_by_day[$event['Date']][$event['Start Time']] = array(); // create empty index for this time, if it doesn't already exist
  }
  if ($event['Live?'] == 'nonstreamed') {
    $nonstreamed_events = TRUE;
  }
  // oh this is so gross... need to find a better way to collapse these "parent" items in the schedule if we're going to keep doing things this way
  if (strpos($event['Event'], 'Paper Session') === 0) {
    $suffix = substr($event['Event'], -2);
    if ($suffix == '-A') {
      // trim off the suffix
      $event['Event'] = substr($event['Event'], 0, -2);
    } elseif ($suffix == '-B' || $suffix = '-C') {
      // skip other rooms
      continue;
    }
  }
  $schedule_by_day[$event['Date']][$event['Start Time']][] = $event; // add this event to our schedule
}

// print '<pre>'; print_r($schedule_by_day); print '</pre>';

function brandon_date($time) {
  $out = date('D, M j', $time);
  $out .= '<sup>';
  $out .= date('S', $time);
  $out .= '</sup>';
  return $out;
}

function count_child_items($events) {
  $child_items = 0;
  foreach ($events as $event) {
    if ($event['Child item?']) {
      $child_items++;
    }
  }
  return $child_items;
}

$now = time(); // ensure that times displayed across the page are consistent

// time for the header...
// we'll exactly match Brandon's markup for now
?><div id="schedule" class="row">
<div class="column small-12 medium-3">
<h2>Schedule</h2>
<h3>For the year <?php print date('Y', $start_time); ?>:</h3>
<ul class="vertical tabs" data-tabs id="schedule-content">
<?php foreach (array_keys($schedule_by_day) as $day) { ?>
<li class="tabs-title"><a href="#schedule-<?php print $day; ?>"><?php print brandon_date(strtotime($day)); ?></a></li>
<?php } ?></div>
<div class="column small-12 medium-9">
<p class="text-right">It is currently <span class="time" data-timezone="US/<?php print $data['tz']; ?>"><?php print brandon_date($now) .' '. date('Y g:i A T', $now); ?></span></p>
<?php if ($nonstreamed_events) { ?>
<div class="text-right"><small class="asterisk">* Events with asterisks will not be streamed.</small></div>
<?php }

// okay that was fun -- now we'll iterate through the days...
?><div class="tabs-content" data-tabs-content="schedule-content">
<?php foreach ($schedule_by_day as $daykey => $daytimes) { ?>
<div class="tabs-panel"	id="schedule-<?php print $daykey; ?>">
<div class="table-scroll"><table class="stacked"><colgroup><col style="width: 40%" /><col style="width: 60%" /></colgroup>
<thead><tr><th>Time</th><th>Title</th></tr></thead>
<tbody>
<?php foreach ($daytimes as $events) {
  $concurrent = (count($events) > 1);
  if ($concurrent) {
    $child_items = count_child_items($events);
  } else {
    $child_items = 1;
  }
  $shown_child_item_time = FALSE;
  foreach ($events as $event) {
    $classes = ($event['Child item?'] ? 'sub-event' : 'main-event');
    $classes .= ($concurrent ? '' : ' no-concurrent');
    $start = strtotime($event['Date'] .' '. $event['Start Time']);
    $end = strtotime($event['Date'] .' '. $event['End Time']);
    $highlight = ($time >= $start && $time < $end);
    $classes .= ($highlight ? ' highlight' : '');
?><tr class="<?php print $classes; ?>">
<?php if ($concurrent && $event['Child item?'] && $child_items > 1) {
if (!$shown_child_item_time) { ?>
<td rowspan="<?php print $child_items; ?>" class="concurrent"><?php print $event['Start Time'] .' - '. $event['End Time']; ?></td><?php
  $shown_child_item_time = TRUE;
}
} else { ?>
<td><?php print $event['Start Time'] .' - '. $event['End Time']; ?></td><?php
} ?>
<td><?php print $event['Event'] . ($event['Live?'] == 'nonstreamed' ? ' *' : ''); ?></td>
<?php }
} ?>
</tbody>
</table></div>
</div>
<?php } ?>
</div>
</div>
</div>
