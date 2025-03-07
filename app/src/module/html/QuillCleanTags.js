import Quill from 'quill';

export class QuillCleanTags {

    constructor(quill, options) {
        this.quill = quill;
        this.Delta = Quill.import('delta');
        this.allowed = options.allowedAttributes;
        this.quill.clipboard.addMatcher(Node.ELEMENT_NODE, (node, delta) => this.cleanHtmlMatcher(node, delta));
    }

    cleanHtmlMatcher(node, delta) {
        return this.cleanDelta(delta);
    }

    cleanDelta(delta) {
        let newDelta = new this.Delta();

        delta.ops.forEach((option) => {
            newDelta.insert(option.insert, this.filterAttributes(option.attributes));
        });

        return newDelta;
    }

    filterAttributes(attributes) {

        if (!attributes) {
            return null;
        }

        const filteredAttributes = {};

        for (const key of this.allowed) {
            if (attributes.hasOwnProperty(key)) {
                filteredAttributes[key] = attributes[key];
            }
        }

        return filteredAttributes;
    }
}
