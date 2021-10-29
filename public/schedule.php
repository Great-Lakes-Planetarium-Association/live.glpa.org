				<?php include(__DIR__ . '/../private/json.php'); ?>
				<?php
					//Get the event data.
					$eventDays	=	(!isset($eventDays)) ? _vc($state, 'data', 'event_days') : $eventDays;

					//Get the active day.
					$active		=	_vc($state, 'data', 'active');

					//If there are days of events.
					if (count($eventDays) > 0) {
						//Get the current year.
						$activeTimestamp	=	strtotime(_vc($eventDays[$active['day']], 'date'));
				?>
					<div id="schedule" class="row">
						<div class="column small-12 medium-3">
							<h2>Schedule</h2>
							<h3>For the year <?php print(date('Y', strtotime($eventDays[0]->date))); ?>:</h3>
							<ul class="vertical tabs" data-tabs id="schedule-content">
							<?php foreach($eventDays as $k => $day) { ?>
								<li class="tabs-title<?php if ($k === $active['day']) { ?> is-active<?php } ?>">
									<a href="#schedule-<?php print($k); ?>"<?php
										if ($k === $active['day']) { ?> aria-selected="true"<?php } ?>>
										<?php print(_vc($day, 'dayString')); ?>
									</a>
								</li>
							<?php } ?>
							</ul>
						</div>
						<div class="column small-12 medium-9">
							<p class="text-right">
								It is currently
								<span class="time" data-timezone="<?php print(_vc($state, 'data', 'timezone')); ?>">
									<?php
										//Set the timezone.
										$timezone	=	_vc($state, 'data', 'timezone');

										//Get the date time.
										include_once(__DIR__ . '/datetime.php');
									?>
								</span>
							</p>
							<div class="text-right">
								<small class="asterisk">* Events with asterisks will not be streamed.</small>
							</div>
							<div class="tabs-content" data-tabs-content="schedule-content">
							<?php foreach($eventDays as $k => $day) { ?>
								<div class="tabs-panel<?php if ($k === $active['day']) { ?> is-active<?php } ?>"
									id="schedule-<?php print($k); ?>">
									<div class="table-scroll">
										<table class="stacked">
											<colgroup>
												<col style="width: 40%" />
												<col style="width: 60%" />
											</colgroup>
											<thead>
												<tr>
													<th>Time</th>
													<th>Title</th>
												</tr>
											</thead>
											<tbody>
								<?php
									//Get the events.
									$events	=	_vc($day, 'events');

									//If there are events.
									if (count($events) > 0 ) {
										//For each event on this day.
										foreach($events as $l => $event) {
											//Get the timestamps.
											$tsSrt	=	strtotime(_vc($day, 'date') . _vc($event, 'start_time'));
											$tsEnd	=	strtotime(_vc($day, 'date') . _vc($event, 'end_time'));
											$hlght	=	(time() > $tsSrt && time() < $tsEnd) ? true : false;

											//Get the streams.
											$streams	=	_vc($event, 'children');

											//If there is a title.
											if (!_vc($event, 'hide')) {
								?>
												<tr class="main-event<?php if ($hlght) { ?> highlight<?php } if (!$streams) {
												?> no-concurrent<?php } ?>">
													<td>
														<?php printf("%s - %s", date('h:i A', $tsSrt),
																date('h:i A', $tsEnd)); ?>
													</td>
													<td>
														<?php print(_vc($event, 'title')); if (!$streams) { ?>*<?php } ?>
													</td>
												</tr>
								<?php
											}

											//If there are streams.
											if ($streams && count($streams) > 0) {
												//For each stream.
												foreach($streams as $m => $stream) {
													//Get the timestamps.
													$tsSrt	=	strtotime(_vc($day, 'date') . _vc($stream, 'start_time'));
													$tsEnd	=	strtotime(_vc($day, 'date') . _vc($stream, 'end_time'));
													$hlght	=	(time() > $tsSrt && time() < $tsEnd) ? true : false;

													//Get the concurrent streams.
													$cStreams	=	_vc($stream, 'concurrent_streams');

													//If there are streams.
													if ($cStreams && count($cStreams) > 0) {
														//For each stream.
														foreach($cStreams as $n => $cStream) {
								?>
												<tr class="sub-event<?php if ($hlght) { ?> highlight<?php } ?>">
												<?php if ($n < 1) { ?>
													<td rowspan="<?php print(count($cStreams)); ?>" class="concurrent">
														<?php printf("%s - %s", date('h:i A', $tsSrt),
																date('h:i A', $tsEnd)); ?>
													</td>
												<?php } ?>
													<td>
														<?php print(_vc($cStream, 'title')); ?>
														<br />
													<?php if (_vc($cStream, 'presenter')) { ?>
														<small>
															Presented by: <?php print(_vc($cStream, 'presenter')); ?>
														</small>
													<?php } ?>
													</td>
												</tr>
								<?php
														}
													}
												}
											}
										}
									}
								?>
											</tbody>
										</table>
									</div>
								</div>
							<?php } ?>
							</div>
						</div>
					</div>
				<?php } ?>
