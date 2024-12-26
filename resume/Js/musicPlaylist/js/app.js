// Import data from '../data.js'
import data from '../data.js';

// Get the progress element
const progress = document.getElementById('progress');

// Get all elements with class 'fa-solid'
const fas = document.querySelectorAll('.fa-solid');

// Get the music track element
const music_track = document.querySelector('.music-track');

// Get the image element
const image = document.querySelector('#image');

// Get the song name element
const song_name = document.querySelector('.song-name');

// Initialize the track_id to 0
let track_id = 0;

// Update the progress value every 500 milliseconds
setInterval(() => {
  progress.value = music_track.currentTime; 
}, 500);

// Update the music track's current time when the progress changes
progress.addEventListener('change', () => {
  music_track.currentTime = progress.value;
});

// Add event listeners to each fa-solid element
fas.forEach(function (fa) {
  fa.addEventListener('click', function () {
    let player = fa.classList.contains('fa-play');
    let pauser = fa.classList.contains('fa-pause');

    // Handle play/pause button click
    if (player) {
      fa.classList.remove('fa-play');
      fa.classList.add('fa-pause');
      music_track.play();
    } else if (pauser) {
      fa.classList.remove('fa-pause');
      fa.classList.add('fa-play');
      music_track.pause();
    }

    // Handle backward button click
    if (fa.classList.contains('fa-backward')) {
      // Calculate the new track_id using modulo to wrap around the array
      track_id = (track_id - 1 + data.length) % data.length;

      // Update the music track, image, and song name with the new track_id
      music_track.src = data[track_id].audio;
      image.src = data[track_id].image;
      song_name.innerHTML = data[track_id].name;

      // Check if the music is playing and update the button icon accordingly
      if (!music_track.paused) {
        fa.classList.remove('fa-play');
        fa.classList.add('fa-pause');
      }
    }

    // Handle forward button click
    if (fa.classList.contains('fa-forward')) {
      // Calculate the new track_id using modulo to wrap around the array
      track_id = (track_id + 1) % data.length;

      // Update the music track, image, and song name with the new track_id
      music_track.src = data[track_id].audio;
      image.src = data[track_id].image;
      song_name.innerHTML = data[track_id].name;

      // Check if the music is playing and update the button icon accordingly
      if (!music_track.paused) {
        fa.classList.remove('fa-play');
        fa.classList.add('fa-pause');
      }
    }
  });
});
