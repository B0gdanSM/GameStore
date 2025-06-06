import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';
import './editor.scss';
import ServerSideRender from '@wordpress/server-side-render';

export default function Edit() {
	return (
		<div {...useBlockProps()}>
			<ServerSideRender
				block="blocks-gamestore/single-news"
			/>
		</div>
	);
}
