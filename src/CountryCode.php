<?php

/*
 * This file is part of the pkg6/paypal
 *
 * (c) pkg6 <https://github.com/pkg6>
 *
 * (L) Licensed <https://opensource.org/license/MIT>
 *
 * (A) zhiqiang <https://www.zhiqiang.wang>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace pkg6\paypal;

/**
 * Class CountryCode.
 *
 * @author zhiqiang
 *
 * @see https://developer.paypal.com/api/rest/reference/country-codes/
 */
class CountryCode
{
    const AL = 'AL';
    const DZ = 'DZ';
    const AD = 'AD';
    const AO = 'AO';
    const AI = 'AI';
    const AG = 'AG';
    const AR = 'AR';
    const AM = 'AM';
    const AW = 'AW';
    const AU = 'AU';
    const AT = 'AT';
    const AZ = 'AZ';
    const BS = 'BS';
    const BH = 'BH';
    const BB = 'BB';
    const BY = 'BY';
    const BE = 'BE';
    const BZ = 'BZ';
    const BJ = 'BJ';
    const BM = 'BM';
    const BT = 'BT';
    const BO = 'BO';
    const BA = 'BA';
    const BW = 'BW';
    const BR = 'BR';
    const VG = 'VG';
    const BN = 'BN';
    const BG = 'BG';
    const BF = 'BF';
    const BI = 'BI';
    const KH = 'KH';
    const CM = 'CM';
    const CA = 'CA';
    const CV = 'CV';
    const KY = 'KY';
    const TD = 'TD';
    const CL = 'CL';
    const C2 = 'C2';
    const CO = 'CO';
    const KM = 'KM';
    const CG = 'CG';
    const CD = 'CD';
    const CK = 'CK';
    const CR = 'CR';
    const CI = 'CI';
    const HR = 'HR';
    const CY = 'CY';
    const CZ = 'CZ';
    const DK = 'DK';
    const DJ = 'DJ';
    const DM = 'DM';
    const DO = 'DO';
    const EC = 'EC';
    const EG = 'EG';
    const SV = 'SV';
    const ER = 'ER';
    const EE = 'EE';
    const ET = 'ET';
    const FK = 'FK';
    const FO = 'FO';
    const FJ = 'FJ';
    const FI = 'FI';
    const FR = 'FR';
    const GF = 'GF';
    const PF = 'PF';
    const GA = 'GA';
    const GM = 'GM';
    const GE = 'GE';
    const DE = 'DE';
    const GI = 'GI';
    const GR = 'GR';
    const GL = 'GL';
    const GD = 'GD';
    const GP = 'GP';
    const GT = 'GT';
    const GN = 'GN';
    const GW = 'GW';
    const GY = 'GY';
    const HN = 'HN';
    const HK = 'HK';
    const HU = 'HU';
    const IS = 'IS';
    const IN = 'IN';
    const ID = 'ID';
    const IE = 'IE';
    const IL = 'IL';
    const IT = 'IT';
    const JM = 'JM';
    const JP = 'JP';
    const JO = 'JO';
    const KZ = 'KZ';
    const KE = 'KE';
    const KI = 'KI';
    const KW = 'KW';
    const KG = 'KG';
    const LA = 'LA';
    const LV = 'LV';
    const LS = 'LS';
    const LI = 'LI';
    const LT = 'LT';
    const LU = 'LU';
    const MK = 'MK';
    const MG = 'MG';
    const MW = 'MW';
    const MY = 'MY';
    const MV = 'MV';
    const ML = 'ML';
    const MT = 'MT';
    const MH = 'MH';
    const MQ = 'MQ';
    const MR = 'MR';
    const MU = 'MU';
    const YT = 'YT';
    const MX = 'MX';
    const FM = 'FM';
    const MD = 'MD';
    const MC = 'MC';
    const MN = 'MN';
    const ME = 'ME';
    const MS = 'MS';
    const MA = 'MA';
    const MZ = 'MZ';
    const NA = 'NA';
    const NR = 'NR';
    const NP = 'NP';
    const NL = 'NL';
    const NC = 'NC';
    const NZ = 'NZ';
    const NI = 'NI';
    const NE = 'NE';
    const NG = 'NG';
    const NU = 'NU';
    const NF = 'NF';
    const NO = 'NO';
    const OM = 'OM';
    const PW = 'PW';
    const PA = 'PA';
    const PG = 'PG';
    const PY = 'PY';
    const PE = 'PE';
    const PH = 'PH';
    const PN = 'PN';
    const PL = 'PL';
    const PT = 'PT';
    const QA = 'QA';
    const RE = 'RE';
    const RO = 'RO';
    const RU = 'RU';
    const RW = 'RW';
    const WS = 'WS';
    const SM = 'SM';
    const ST = 'ST';
    const SA = 'SA';
    const SN = 'SN';
    const RS = 'RS';
    const SC = 'SC';
    const SL = 'SL';
    const SG = 'SG';
    const SK = 'SK';
    const SI = 'SI';
    const SB = 'SB';
    const SO = 'SO';
    const ZA = 'ZA';
    const KR = 'KR';
    const ES = 'ES';
    const LK = 'LK';
    const SH = 'SH';
    const KN = 'KN';
    const LC = 'LC';
    const PM = 'PM';
    const VC = 'VC';
    const SR = 'SR';
    const SJ = 'SJ';
    const SZ = 'SZ';
    const SE = 'SE';
    const CH = 'CH';
    const TW = 'TW';
    const TJ = 'TJ';
    const TZ = 'TZ';
    const TH = 'TH';
    const TG = 'TG';
    const TO = 'TO';
    const TT = 'TT';
    const TN = 'TN';
    const TM = 'TM';
    const TC = 'TC';
    const TV = 'TV';
    const UG = 'UG';
    const UA = 'UA';
    const AE = 'AE';
    const GB = 'GB';
    const US = 'US';
    const UY = 'UY';
    const VU = 'VU';
    const VA = 'VA';
    const VE = 'VE';
    const VN = 'VN';
    const WF = 'WF';
    const YE = 'YE';
    const ZM = 'ZM';
    const ZW = 'ZW';

    const codes = [
        self::AL => 'ALBANIA',
        self::DZ => 'ALGERIA',
        self::AD => 'ANDORRA',
        self::AO => 'ANGOLA',
        self::AI => 'ANGUILLA',
        self::AG => 'ANTIGUA & BARBUDA',
        self::AR => 'ARGENTINA',
        self::AM => 'ARMENIA',
        self::AW => 'ARUBA',
        self::AU => 'AUSTRALIA',
        self::AT => 'AUSTRIA',
        self::AZ => 'AZERBAIJAN',
        self::BS => 'BAHAMAS',
        self::BH => 'BAHRAIN',
        self::BB => 'BARBADOS',
        self::BY => 'BELARUS',
        self::BE => 'BELGIUM',
        self::BZ => 'BELIZE',
        self::BJ => 'BENIN',
        self::BM => 'BERMUDA',
        self::BT => 'BHUTAN',
        self::BO => 'BOLIVIA',
        self::BA => 'BOSNIA & HERZEGOVINA',
        self::BW => 'BOTSWANA',
        self::BR => 'BRAZIL',
        self::VG => 'BRITISH VIRGIN ISLANDS',
        self::BN => 'BRUNEI',
        self::BG => 'BULGARIA',
        self::BF => 'BURKINA FASO',
        self::BI => 'BURUNDI',
        self::KH => 'CAMBODIA',
        self::CM => 'CAMEROON',
        self::CA => 'CANADA',
        self::CV => 'CAPE VERDE',
        self::KY => 'CAYMAN ISLANDS',
        self::TD => 'CHAD',
        self::CL => 'CHILE',
        self::C2 => 'CHINA',
        self::CO => 'COLOMBIA',
        self::KM => 'COMOROS',
        self::CG => 'CONGO - BRAZZAVILLE',
        self::CD => 'CONGO - KINSHASA',
        self::CK => 'COOK ISLANDS',
        self::CR => 'COSTA RICA',
        self::CI => 'CÔTE D’IVOIRE',
        self::HR => 'CROATIA',
        self::CY => 'CYPRUS',
        self::CZ => 'CZECH REPUBLIC',
        self::DK => 'DENMARK',
        self::DJ => 'DJIBOUTI',
        self::DM => 'DOMINICA',
        self::DO => 'DOMINICAN REPUBLIC',
        self::EC => 'ECUADOR',
        self::EG => 'EGYPT',
        self::SV => 'EL SALVADOR',
        self::ER => 'ERITREA',
        self::EE => 'ESTONIA',
        self::ET => 'ETHIOPIA',
        self::FK => 'FALKLAND ISLANDS',
        self::FO => 'FAROE ISLANDS',
        self::FJ => 'FIJI',
        self::FI => 'FINLAND',
        self::FR => 'FRANCE',
        self::GF => 'FRENCH GUIANA',
        self::PF => 'FRENCH POLYNESIA',
        self::GA => 'GABON',
        self::GM => 'GAMBIA',
        self::GE => 'GEORGIA',
        self::DE => 'GERMANY',
        self::GI => 'GIBRALTAR',
        self::GR => 'GREECE',
        self::GL => 'GREENLAND',
        self::GD => 'GRENADA',
        self::GP => 'GUADELOUPE',
        self::GT => 'GUATEMALA',
        self::GN => 'GUINEA',
        self::GW => 'GUINEA-BISSAU',
        self::GY => 'GUYANA',
        self::HN => 'HONDURAS',
        self::HK => 'HONG KONG SAR CHINA',
        self::HU => 'HUNGARY',
        self::IS => 'ICELAND',
        self::IN => 'INDIA',
        self::ID => 'INDONESIA',
        self::IE => 'IRELAND',
        self::IL => 'ISRAEL',
        self::IT => 'ITALY',
        self::JM => 'JAMAICA',
        self::JP => 'JAPAN',
        self::JO => 'JORDAN',
        self::KZ => 'KAZAKHSTAN',
        self::KE => 'KENYA',
        self::KI => 'KIRIBATI',
        self::KW => 'KUWAIT',
        self::KG => 'KYRGYZSTAN',
        self::LA => 'LAOS',
        self::LV => 'LATVIA',
        self::LS => 'LESOTHO',
        self::LI => 'LIECHTENSTEIN',
        self::LT => 'LITHUANIA',
        self::LU => 'LUXEMBOURG',
        self::MK => 'MACEDONIA',
        self::MG => 'MADAGASCAR',
        self::MW => 'MALAWI',
        self::MY => 'MALAYSIA',
        self::MV => 'MALDIVES',
        self::ML => 'MALI',
        self::MT => 'MALTA',
        self::MH => 'MARSHALL ISLANDS',
        self::MQ => 'MARTINIQUE',
        self::MR => 'MAURITANIA',
        self::MU => 'MAURITIUS',
        self::YT => 'MAYOTTE',
        self::MX => 'MEXICO',
        self::FM => 'MICRONESIA',
        self::MD => 'MOLDOVA',
        self::MC => 'MONACO',
        self::MN => 'MONGOLIA',
        self::ME => 'MONTENEGRO',
        self::MS => 'MONTSERRAT',
        self::MA => 'MOROCCO',
        self::MZ => 'MOZAMBIQUE',
        self::NA => 'NAMIBIA',
        self::NR => 'NAURU',
        self::NP => 'NEPAL',
        self::NL => 'NETHERLANDS',
        self::NC => 'NEW CALEDONIA',
        self::NZ => 'NEW ZEALAND',
        self::NI => 'NICARAGUA',
        self::NE => 'NIGER',
        self::NG => 'NIGERIA',
        self::NU => 'NIUE',
        self::NF => 'NORFOLK ISLAND',
        self::NO => 'NORWAY',
        self::OM => 'OMAN',
        self::PW => 'PALAU',
        self::PA => 'PANAMA',
        self::PG => 'PAPUA NEW GUINEA',
        self::PY => 'PARAGUAY',
        self::PE => 'PERU',
        self::PH => 'PHILIPPINES',
        self::PN => 'PITCAIRN ISLANDS',
        self::PL => 'POLAND',
        self::PT => 'PORTUGAL',
        self::QA => 'QATAR',
        self::RE => 'RÉUNION',
        self::RO => 'ROMANIA',
        self::RU => 'RUSSIA',
        self::RW => 'RWANDA',
        self::WS => 'SAMOA',
        self::SM => 'SAN MARINO',
        self::ST => 'SÃO TOMÉ & PRÍNCIPE',
        self::SA => 'SAUDI ARABIA',
        self::SN => 'SENEGAL',
        self::RS => 'SERBIA',
        self::SC => 'SEYCHELLES',
        self::SL => 'SIERRA LEONE',
        self::SG => 'SINGAPORE',
        self::SK => 'SLOVAKIA',
        self::SI => 'SLOVENIA',
        self::SB => 'SOLOMON ISLANDS',
        self::SO => 'SOMALIA',
        self::ZA => 'SOUTH AFRICA',
        self::KR => 'SOUTH KOREA',
        self::ES => 'SPAIN',
        self::LK => 'SRI LANKA',
        self::SH => 'ST. HELENA',
        self::KN => 'ST. KITTS & NEVIS',
        self::LC => 'ST. LUCIA',
        self::PM => 'ST. PIERRE & MIQUELON',
        self::VC => 'ST. VINCENT & GRENADINES',
        self::SR => 'SURINAME',
        self::SJ => 'SVALBARD & JAN MAYEN',
        self::SZ => 'SWAZILAND',
        self::SE => 'SWEDEN',
        self::CH => 'SWITZERLAND',
        self::TW => 'TAIWAN',
        self::TJ => 'TAJIKISTAN',
        self::TZ => 'TANZANIA',
        self::TH => 'THAILAND',
        self::TG => 'TOGO',
        self::TO => 'TONGA',
        self::TT => 'TRINIDAD & TOBAGO',
        self::TN => 'TUNISIA',
        self::TM => 'TURKMENISTAN',
        self::TC => 'TURKS & CAICOS ISLANDS',
        self::TV => 'TUVALU',
        self::UG => 'UGANDA',
        self::UA => 'UKRAINE',
        self::AE => 'UNITED ARAB EMIRATES',
        self::GB => 'UNITED KINGDOM',
        self::US => 'UNITED STATES',
        self::UY => 'URUGUAY',
        self::VU => 'VANUATU',
        self::VA => 'VATICAN',
        self::VE => 'VENEZUELA',
        self::VN => 'VIETNAM',
        self::WF => 'WALLIS & FUTUNA',
        self::YE => 'YEMEN',
        self::ZM => 'ZAMBIA',
        self::ZW => 'ZIMBABWE',
    ];

    public static function codes()
    {
        return array_keys(self::codes);
    }
}
