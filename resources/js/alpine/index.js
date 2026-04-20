import Alpine from 'alpinejs'
import sort from '@alpinejs/sort'

Alpine.plugin(sort)

window.Alpine = Alpine

import blockManager from './components/blockManager';
Alpine.data('blockManager', blockManager);

Alpine.start()