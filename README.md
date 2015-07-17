# Rakuten Web Service SDK for PHP

This package is another version for https://github.com/rakuten-ws/rws-php-sdk/ with support of PHP namespace. Works well with Yii2 and Laravel.

# Installation:

    {
        "require": {
            "bsushil/rakuten-api": "dev-master"
        }
    }

For API information and the document, refer to the original (and official) library.


# Usage:
            use Rakuten\Client;

            $client = new Client();
            $client->setApplicationId(apiKey);
            $client->setAffiliateId(affiliateID);

            $response = $client->execute('IchibaItemSearch', ['keyword'=>$searchKey, 'hits'=>$pageSize, 'page'=>$page]);
            $responseCode = $response->getCode();

            if($responseCode != 200)
            {
                $arReturn['message'] = $response->getMessage();
            }
            else
            {
                $data = $response->getData();
                $arData = [];
                $arData['totalRecords'] = $data['count'];
                $arData['pageCount'] = $data['pageCount'];
                $arData['data'] = $data['Items'];
                $arReturn['data'] = $arData;
            }
