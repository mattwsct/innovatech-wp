<?php get_header(); ?>

<section class="page-wrapper">
	
		<div class="pageWrapper">
			
				<div class="pagePost">
						<h1><?php the_title(); ?></h1>
							<div class="companyP">
								<table>
									<tr>
										<th>会社名</th>
										<td>イノバテックスタジオ株式会社<br>innovatech studio Co., Ltd</td>
									</tr>
									<tr>
										<th>代表者</th>
										<td>代表取締役　瀬沼 健吾</td>
									</tr>
									<tr>
										<th>所在地</th>
										<td>135-0052<br>東京都江東区潮見2-8-10 潮見SIFビル2F</td>
									</tr>
									<tr>
										<th>設立</th>
										<td>2018年7月17日</td>
									</tr>
								</table>
								<table>
									<tr>
										<th>事業内容</th>
										<td>
											システム開発事業<br>
											ソフトウェア販売事業<br>
											技術研究事業<br>
											コンサルティング事業<br>
											AI / ロボティクス開発<br>
											クラウド / インフラ基盤構築・運用<br>
											Webアプリケーション開発<br>
											iOS / Android アプリ開発
										</td>
									</tr>
									<tr>
										<th>資本金</th>
										<td>5,000万円</td>
									</tr>
									<tr>
										<th>株主</th>
										<td>センコーグループホールディングス株式会社(100%)</td>
									</tr>
									<tr>
										<th>取引銀行</th>
										<td>三菱UFJ銀行</td>
									</tr>
								</table>
							</div>
			</div>
  </div>

					
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAcVeO3HZCKJoqdUIdEgqiu4RiO0v0Oo-M"></script>
        <script src="//cdn.mapkit.io/v1/infobox.js"></script>
        <link href="//fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
        <link href="//cdn.mapkit.io/v1/infobox.css" rel="stylesheet" >


        <script>
          google.maps.event.addDomListener(window, 'load', init);
            var map, markersArray = [];
            function bindInfoWindow(marker, map, location) {
              google.maps.event.addListener(marker, 'click', function() {
                function close(location) {
                  location.ib.close();
                  location.infoWindowVisible = false;
                  location.ib = null;
                }
                if (location.infoWindowVisible === true) {
                  close(location);
                } else {
                  markersArray.forEach(function(loc, index) {
                    if (loc.ib && loc.ib !== null) {
                      close(loc);
                    }
                  });
                  var boxText = document.createElement('div');
                  boxText.style.cssText = 'background: #fff;';
                  boxText.classList.add('md-whiteframe-2dp');

                  function buildPieces(location, el, part, icon) {
                    if (location[part] === '') {
                      return '';
                    } else if (location.iw[part]) {
                      switch (el) {
                        case 'photo':
                          if (location.photo) {
                            return '<div class="iw-photo" style="background-image: url(' + location.photo + ');"></div>';
                          } else {
                            return '';
                          }
                          break;
                        case 'iw-toolbar':
                          return '<div class="iw-toolbar"><h3 class="md-subhead">' + location.title + '</h3></div>';
                          break;
                        case 'div':
                          switch (part) {
                            case 'email':
                              return '<div class="iw-details"><i class="material-icons" style="color:#4285f4;"><img src="//cdn.mapkit.io/v1/icons/' + icon + '.svg"/></i><span><a href="mailto:' + location.email + '" target="_blank">' + location.email + '</a></span></div>'
                              break;
                            case 'web':
                              return '<div class="iw-details"><i class="material-icons" style="color:#4285f4;"><img src="//cdn.mapkit.io/v1/icons/' + icon + '.svg"/></i><span><a href="' + location.web + '" target="_blank">' + location.web_formatted + '</a></span></div>';
                              break;
                            case 'desc':
                              return '<label class="iw-desc" for="cb_details"><input type="checkbox" id="cb_details"/><h3 class="iw-x-details">Details</h3><i class="material-icons toggle-open-details"><img src="//cdn.mapkit.io/v1/icons/' + icon + '.svg"/></i><p class="iw-x-details">' + location.desc + '</p></label>';
                              break;
                            default:
                              return '<div class="iw-details"><i class="material-icons"><img src="//cdn.mapkit.io/v1/icons/' + icon + '.svg"/></i><span>' + location.part + '</span></div>';
                              break;
                          }
                          break;
                        case 'open_hours':
                          var items = '';
                          if (location.open_hours.length > 0) {
                            for (var i = 0; i < location.open_hours.length; ++i) {
                              if (i !== 0) {
                                items += '<li><strong>' + location.open_hours[i].day + '</strong><strong>' + location.open_hours[i].hours + '</strong></li>';
                              }
                              var first = '<li><label for="cb_hours"><input type="checkbox" id="cb_hours"/><strong>location.open_hours[0].day</strong><strong>' + location.open_hours[0].hours + '</strong><i class="material-icons toggle-open-hours"><img src="//cdn.mapkit.io/v1/icons/keyboard_arrow_down.svg"/></i><ul>' + items + '</ul></label></li>';
                            }
                            return '<div class="iw-list"><i class="material-icons first-material-icons" style="color:#4285f4;"><img src="//cdn.mapkit.io/v1/icons/' + icon + '.svg"/></i><ul>' + first + '</ul></div>';
                          } else {
                            return '';
                          }
                          break;
                      }
                    } else {
                      return '';
                    }
                  }
                  boxText.innerHTML = buildPieces(location, 'photo', 'photo', '') + buildPieces(location, 'iw-toolbar', 'title', '') + buildPieces(location, 'div', 'address', 'location_on') + buildPieces(location, 'div', 'web', 'public') + buildPieces(location, 'div', 'email', 'email') + buildPieces(location, 'div', 'tel', 'phone') + buildPieces(location, 'div', 'int_tel', 'phone') + buildPieces(location, 'open_hours', 'open_hours', 'access_time') + buildPieces(location, 'div', 'desc', 'keyboard_arrow_down');
                  var myOptions = {
                    alignBottom: true,
                    content: boxText,
                    disableAutoPan: true,
                    maxWidth: 0,
                    pixelOffset: new google.maps.Size(-140, -40),
                    zIndex: null,
                    boxStyle: {
                      opacity: 1,
                      width: '280px'
                    },
                    closeBoxMargin: '0px 0px 0px 0px',
                    infoBoxClearance: new google.maps.Size(1, 1),
                    isHidden: false,
                    pane: 'floatPane',
                    enableEventPropagation: false
                  };
                  location.ib = new InfoBox(myOptions);
                  location.ib.open(map, marker);
                  location.infoWindowVisible = true;
                }
              });
            }

            function init() {
              var mapOptions = {
                center: new google.maps.LatLng(35.65908463835263, -220.18084602698366),
                zoom: 15,gestureHandling: 'auto',fullscreenControl: true,zoomControl: true,
                disableDoubleClickZoom: true,
                
                mapTypeControl: true,
                mapTypeControlOptions: {
                  style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                },
                scaleControl: true,
                scrollwheel: false,
                streetViewControl: true,
                draggable: true,
                clickableIcons: false,
                fullscreenControlOptions: {
                  position: google.maps.ControlPosition.TOP_RIGHT
                },
                zoomControlOptions: {
                  position: google.maps.ControlPosition.RIGHT_BOTTOM
                },
                streetViewControlOptions: {
                  position: google.maps.ControlPosition.RIGHT_BOTTOM
                },
                mapTypeControlOptions: {
                  position: google.maps.ControlPosition.TOP_LEFT
                },
                
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                
                styles: [{"stylers":[{"hue":"#2c3e50"},{"saturation":250}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":50},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]}]
                
              }
              var mapElement = document.getElementById('mapkit-7981');
              var map = new google.maps.Map(mapElement, mapOptions);
              var locations = [{"title":"潮見ＳＩＦビル","address":"日本、〒135-0052 東京都江東区潮見２丁目８","desc":"","tel":"","int_tel":"","email":"","web":"","web_formatted":"","open":"","time":"","lat":35.6589655,"lng":139.8199422,"vicinity":"日本、〒135-0052 東京都江東区潮見２丁目８","marker":"","iw":{"address":true,"desc":true,"email":true,"enable":true,"int_tel":true,"open":true,"open_hours":true,"photo":true,"tel":true,"title":true,"web":true}}];
              
              for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                icon: locations[i].marker,
                position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
                map: map,
                title: locations[i].title,
                address: locations[i].address,
                desc: locations[i].desc,
                tel: locations[i].tel,
                int_tel: locations[i].int_tel,
                vicinity: locations[i].vicinity,
                open: locations[i].open,
                open_hours: locations[i].open_hours,
                photo: locations[i].photo,
                time: locations[i].time,
                email: locations[i].email,
                web: locations[i].web,
                iw: locations[i].iw
              });

              markersArray.push(marker);

              if (locations[i].iw.enable === true){
                bindInfoWindow(marker, map, locations[i]);
              }
            }
            
            }
        </script>

        <style>
          #mapkit-7981 {
            height: 800px;
            width: 100%;
          }
        </style>

        <div id="mapkit-7981"></div>
						
</section>

<?php get_footer(); ?>

