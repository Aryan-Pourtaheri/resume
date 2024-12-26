document.addEventListener('DOMContentLoaded', function() {
  const music_notes = document.querySelectorAll('.music-note');

  music_notes.forEach(note => {
    note.addEventListener('click', note_click);
  });

  addEventListener('keydown', note_key);

  function note_click() {
    if (this.classList.contains('do')) {
      let do_note = new Audio('../sounds/do.mp3');
      do_note.playbackRate = 1.5;
      do_note.play();
    } else if (this.classList.contains('re')) {
      let re_note = new Audio('../sounds/re.mp3');
      re_note.play();
    } else if (this.classList.contains('mi')) {
      let mi_note = new Audio('../sounds/mi.mp3');
      mi_note.play();
    } else if (this.classList.contains('fa')) {
      let fa_note = new Audio('../sounds/fa.mp3');
      fa_note.play();
    } else if (this.classList.contains('sol')) {
      let sol_note = new Audio('../sounds/sol.mp3');
      sol_note.play();
      console.log('sol')
    } else if (this.classList.contains('la')) {
      let la_note = new Audio('../sounds/la.mp3');
      la_note.play();
    } else if (this.classList.contains('si')) {
      let si_note = new Audio('../sounds/si.mp3');
      si_note.play();
    } else if (this.classList.contains('do-stretched')) {
      let do_stretched_note = new Audio('../sounds/do-stretched.mp3');
      do_stretched_note.play();
    }
  }


  function note_key(e) {
    switch(e.key.toUpperCase()) {
      case 'A':
        let do_note = new Audio('../sounds/do.mp3');
        do_note.playbackRate = 1.5;
        do_note.play();
        break;
      case 'S':
        let re_note = new Audio('../sounds/re.mp3');
        re_note.play();
        break;
      case 'D':
        let mi_note = new Audio('../sounds/mi.mp3');
        mi_note.playbackRate = 2;
        mi_note.play();
        break;
      case 'F':
        let fa_note = new Audio('../sounds/fa.mp3');
        fa_note.playbackRate = 2;
        fa_note.play();
        break;
      case 'J':
        let sol_note = new Audio('../sounds/sol.mp3');
        sol_note.play();
        break;
      case 'K':
        let la_note = new Audio('../sounds/la.mp3');
        la_note.play();
        break;
      case 'L':
        let si_note = new Audio('../sounds/si.mp3');
        si_note.playbackRate = 3;
        si_note.play();
        break;
      case ';':
        let do_stretched_note = new Audio('../sounds/do-stretched.mp3');
        do_stretched_note.playbackRate = 0.5;
        do_stretched_note.play();
        break;
    }
  }

});

