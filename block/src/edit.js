/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-block-editor/#useBlockProps
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
//import './editor.scss';

import {
	InspectorControls,
} from '@wordpress/block-editor';

import {
	PanelBody,
	TextControl,
} from '@wordpress/components';

export default function Edit( props ) {
	const { attributes: { linkText }, className, setAttributes } = props;
	const setText = (
		<TextControl
			label={ __( 'Title:', 'custom-nextpage' ) }
			help={ __( 'Text to put before the title navigation', 'custom-nextpage' ) }
			className="user-link-text"
			tagName="span"
			value={ linkText }
			placeholder={ __( 'Enter the link text…', 'custom-nextpage' ) }
			onChange={ ( newValue ) => {
				props.setAttributes( {
					linkText: newValue ? newValue : '',
				} );
			} }
		/>
	);

	return (
		<>
			<Fragment>
				<InspectorControls>
					<PanelBody title={ __( 'Option', 'custom-nextpage' ) }>
						{ setText }
					</PanelBody>
				</InspectorControls>
				<div className='event-editor' { ...useBlockProps() }>
					<img src={image_data.customNextPageImage} alt={ 'Next Page' } />
				</div>
			</Fragment>
		</>
	);
}
