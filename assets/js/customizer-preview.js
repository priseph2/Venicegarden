/* Customizer live-preview: updates CSS vars instantly when palette or
   individual colour controls change, without a full page reload.
   Loaded only inside the Customizer preview iframe. */
(function () {
    'use strict';

    var palettes = window._vgPalettes || {};

    function setCSSVars(gold, obsidian, cream) {
        var style = document.getElementById('vg-customizer-colors');
        if (!style) {
            style = document.createElement('style');
            style.id = 'vg-customizer-colors';
            document.head.appendChild(style);
        }
        style.textContent =
            ':root{' +
            '--gold:'    + gold    + ';' +
            '--obsidian:'+ obsidian+ ';' +
            '--cream:'   + cream   + ';' +
            '}';
    }

    /* Palette selector ─────────────────────────────────────────── */
    wp.customize('vg_color_palette', function (value) {
        value.bind(function (key) {
            if (key !== 'custom' && palettes[key]) {
                setCSSVars(palettes[key].gold, palettes[key].obsidian, palettes[key].cream);
            } else {
                setCSSVars(
                    wp.customize('vg_color_gold').get(),
                    wp.customize('vg_color_obsidian').get(),
                    wp.customize('vg_color_cream').get()
                );
            }
        });
    });

    /* Individual colour pickers (active in Custom mode) ─────────── */
    ['vg_color_gold', 'vg_color_obsidian', 'vg_color_cream'].forEach(function (key) {
        wp.customize(key, function (value) {
            value.bind(function () {
                if (wp.customize('vg_color_palette').get() === 'custom') {
                    setCSSVars(
                        wp.customize('vg_color_gold').get(),
                        wp.customize('vg_color_obsidian').get(),
                        wp.customize('vg_color_cream').get()
                    );
                }
            });
        });
    });
}());
