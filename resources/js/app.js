import tinymce from 'tinymce/tinymce'
import 'tinymce/themes/silver/theme'
import 'tinymce/models/dom/model'
import 'tinymce/icons/default/icons'
import 'tinymce/skins/ui/oxide/skin.css'
import 'tinymce/plugins/link'
import 'tinymce/plugins/lists'
import 'tinymce/plugins/code'
import 'tinymce/plugins/table'

import "@fontsource/inter/index.css"; 
import '@qpokychuk/gilroy/index.css';
import '@qpokychuk/gilroy/normal.css';
import '@qpokychuk/gilroy/italic.css';

import '../scss/app.scss';
import './bootstrap';

import './admin';
import './web';

import './alpine/start';

document.querySelectorAll('*').forEach(el => {
  if (el.scrollWidth > document.documentElement.clientWidth) {
    console.log(el, el.scrollWidth);
  }
});
