import BlockEditor from './blockEditor.ts';

import Quill from 'quill';
import { QuillCleanTags } from '/src/module/html/QuillCleanTags';
Quill.register('modules/cleanTags', QuillCleanTags);

// backward compatibility
var blockEditor = BlockEditor;
document.vueeditor = BlockEditor;

export default blockEditor;