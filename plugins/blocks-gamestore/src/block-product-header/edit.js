import { useBlockProps, RichText, InspectorControls, MediaPlaceholder } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {
  const { title, image } = attributes;

	return (
    <>
    <InspectorControls>
      <PanelBody title={ __( 'Settings', 'blocks-gamestore' ) }>
        <TextControl
          label={ __( 'Title', 'blocks-gamestore' ) }
          value={ title }
          onChange={ ( title ) => setAttributes( { title } ) }
        />
        {image && (<img src={image} />)}
        <MediaPlaceholder
          icon="format-image"
          labels={ { title: 'Image' } }
          onSelect={ ( media ) => setAttributes( { image: media.url } ) }
          accept="image/*"
          allowedTypes={ [ 'image' ] }
          notices={ [ 'Image' ] }
        />
      </PanelBody>
    </InspectorControls>
    <div { ...useBlockProps({
      className: "alignfull",
      style: {
        background: image ? `url(${image})` : undefined,
      }
    }) }>
      <div className='wrapper'>
        <RichText
          tagName="h1"
          className='shop-header-title'
          value={title}
          onChange={(title) => setAttributes({ title })}
        />
      </div>
		</div>
    </>
	);
}
