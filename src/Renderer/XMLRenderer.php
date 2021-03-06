<?php

namespace JasperFW\JasperFW\Renderer;

use JasperFW\Core\XML\Array2XML;
use JasperFW\JasperFW\Lifecycle\Response;

class XMLRenderer extends DownloadableRenderer
{
    protected $contentType = 'application/xml; charset=utf-8';
    protected $extension = 'xml';

    public function render(Response $response): void
    {
        parent::render($response);
        $this->getHeaders();
        // Assemble the values and output
        $rootElement = $response->getValues()['rootElement'] ?? 'root';
        $xml = Array2XML::createXML($rootElement, $response->getData());
        echo $xml->saveXML();
    }
}