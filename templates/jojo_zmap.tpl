<script src="http://mapapi.zoomin.co.nz/?v=7&amp;apikey={$OPTIONS.zmapskey}" type="text/javascript"></script>

<div class='jojo_map' id="map{$mapid}" style="width: {$map.mp_width}px; height: {$map.mp_height}px;"></div>

<script type="text/javascript">{literal}

if (GBrowserIsCompatible()) {{/literal}
        /* Start the map */
        var map{$mapid} = new GMap2(document.getElementById("map{$mapid}"));
        map{$mapid}.addMapType(new Zoomin.NZTM);
        map{$mapid}.setCenter(new GLatLng(5918873.18, 1757359.23), 5);
        map{$mapid}.addControl(new GSmallMapControl());
        map{$mapid}.addControl(new GMapTypeControl());

        {if $map.mp_scale=='yes'}
            map{$mapid}.addControl(new GScaleControl());
        {/if}
        {if $map.mp_scroll=='yes'}
            map{$mapid}.addWheelControl();
        {/if}

        /* Boundry Object */
        bounds = new GLatLngBounds();
{literal}
        /* Add the markers */
        var options = {
            draggable: false,
            bouncy: false,
            intert: false
        };

        var point;
{/literal}
{foreach from=$mapLocations key=k item=m}
        point = new GLatLng({$m.lat}, {$m.long}, GLatLng.WGS84);
        bounds.extend(point);
        var marker{$mapid}j{$k} = new GMarker(point);
        map{$mapid}.addOverlay(marker{$mapid}j{$k});
        GEvent.addListener(
            marker{$mapid}j{$k},
            "click",
            {literal}function() {
                marker{/literal}{$mapid}j{$k}{literal}.openInfoWindowHtml(document.getElementById('mapDescription{/literal}{$mapid}j{$k}{literal}').innerHTML);
            }{/literal}
        );

{/foreach}
        {if $mapLocations}
            zoom = map{$mapid}.getBoundsZoomLevel(bounds);
            map{$mapid}.setCenter(bounds.getCenter(), zoom);
        {/if}
        {if $map.mp_zoom != 'auto'}
            map{$mapid}.setZoom({$map.mp_zoom});
        {/if}

{literal}
    }
{/literal}</script>

<div style='display: none'>
{foreach from=$mapLocations key=k item=m}
<span id='mapDescription{$mapid}j{$k}'>
    <string>{$m.ml_name}</strong><br/>
    {$m.ml_description|nl2br}
</span>
{/foreach}
</div>