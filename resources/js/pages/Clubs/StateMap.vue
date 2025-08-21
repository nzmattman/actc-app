<template>
  <Head :title="name" />
  <AuthenticatedLayout
    :title="state"
    :backRoute="route('clubs')"
    :full-width="true"
    :full-height="true"
  >
    <Nav :state="state" :clubs="clubs.length" :slug="slug" />
    <div ref="mapEl" class="map"></div>
  </AuthenticatedLayout>
</template>

<script setup lang="ts">
import { ClubListItem } from '@/entities';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Nav from '@/Pages/Clubs/components/Nav.vue';
import { Loader } from '@googlemaps/js-api-loader';
import MapMarker from '@img/map-marker.png';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

interface Props {
  clubs: ClubListItem[];
  state: string;
  slug: string;
  name: string;
}

const props = defineProps<Props>();

const mapEl = ref(null);

const loader = new Loader({
  apiKey: import.meta.env.VITE_GOOGLE_MAPS_API_KEY,
  version: 'weekly',
  libraries: ['marker'],
});

const initMap = () => {
  if (!mapEl.value) {
    return;
  }

  const map = new google.maps.Map(mapEl.value, {
    mapId: import.meta.env.VITE_GOOGLE_MAPS_MAP_ID,
    center: {
      lat: props.clubs[0].latitude,
      lng: props.clubs[0].longitude,
    },
    zoom: 15,
    zoomControl: false,
    streetViewControl: false,
    mapTypeControl: false,
    scrollwheel: false,
    fullscreenControl: false,
  });

  const bounds = new google.maps.LatLngBounds();

  props.clubs.forEach((club: ClubListItem) => {
    const markerIcon = document.createElement('img');
    markerIcon.src = MapMarker;

    const marker = new google.maps.marker.AdvancedMarkerElement({
      map,
      position: {
        lat: club.latitude,
        lng: club.longitude,
      },
      content: markerIcon,
      gmpClickable: true,
    });

    bounds.extend(marker.position);

    marker.addListener('click', () => {
      router.visit(
        route('clubs.club', {
          slug: props.slug,
          club: club.id,
        }),
      );
    });

    // Show title on hover
    marker.addEventListener('mouseenter', () => {
      // Create and show tooltip/title
      const tooltip = document.createElement('div');
      tooltip.textContent = club.name;
      tooltip.style.cssText = `
      position: absolute;
      background: rgba(0, 0, 0, 0.8);
      color: #ffffff;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 14px;
      pointer-events: none;
      z-index: 1000;
      white-space: nowrap;
      top: 100%;
      left: 50%;
      transform: translateX(-50%);
      margin-top: 5px;
    `;
      tooltip.id = `tooltip-${club.id}`;

      // Position tooltip above the marker
      const markerElement = marker.element;
      if (markerElement) {
        markerElement.appendChild(tooltip);
      }
    });

    // Hide title when mouse leaves
    marker.addEventListener('mouseleave', () => {
      const tooltip = document.getElementById(`tooltip-${club.id}`);
      if (tooltip) {
        tooltip.remove();
      }
    });
  });

  const maxZoom = 17;

  // force the map to size to fit all markers
  map.fitBounds(bounds, { maxZoom, padding: 50 });

  const listener = google.maps.event.addListener(map, 'idle', () => {
    if (map.getZoom() > maxZoom) {
      map.setZoom(maxZoom);
    }

    // Remove the listener so it only fires once
    google.maps.event.removeListener(listener);
  });
};

onMounted(async () => {
  await loader.importLibrary('maps');
  initMap();

  localStorage.setItem('clubs.state.view', 'map');
});
</script>

<style scoped>
.map {
  height: calc(100vh - var(--header-height) - var(--footer-height));
  width: 100%;
  position: relative;
  z-index: 1;
}

.club-nav {
  z-index: 2;
  padding-block: 1rem;
  background: linear-gradient(
    to bottom,
    var(--black) 10%,
    rgba(0, 0, 0, 0) 100%
  );
}

.app__body {
  padding-bottom: 0;
}
</style>
