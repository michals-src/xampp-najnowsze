const {registerBlockType} = wp.blocks;

registerBlockType('bbb/custom-b', {
    'title': 'Call to Action',
    'description': 'abc',
    'icon': 'format-icon',
    'category': 'layout',

    'attributes': {},

    edit(){
        return <p>Paragraph Text</p>;
    },

    save(){}
});