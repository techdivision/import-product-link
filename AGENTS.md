# AGENTS.md - import-product-link

## Zweck & Verantwortung

Das `import-product-link` Modul bietet **Product Link Import-Funktionalität** für Product Relations (Related, Upsell, Crosssell). Es ist ein **Tier 5 Modul** in der Import-Architektur und erweitert das `import-product` Modul mit spezialisierten Funktionen für Produktrelationen.

**Hauptverantwortung:**
- Product Link Import (Related, Upsell, Crosssell, Associated)
- Link Attribute Import (Quantity, Position)
- Repository Pattern Implementation für persistente Speicherung
- Service Layer für Link-spezifische Business Logic
- Observer Pattern für Hook-Integration in der Import-Pipeline
- Link Type Management und Validierung

**Modul-Kategorie:** Integration/Extension Module  
**Komplexität:** ⭐⭐⭐ (Mittel)  
**Wichtigkeit:** Basis für **2 Reverse Dependencies** (Grouped + Link-EE)

## Architektur & Design Patterns

### Kern-Klassen
- **ProductLinkRepository**: Persistiert Product Link Relationen
- **ProductLinkAttributeRepository**: Verwaltet Link Attribute (Quantity, Position)
- **ProductLinkProcessor**: Service Layer für Link-Verarbeitung
- **ProductLinkObserver**: Observer für Lifecycle Hooks
- **LinkTypeValidator**: Validiert Link Types und Relationen
- **LinkAssociationManager**: Koordiniert bidirektionale Link-Zuordnungen

### Verwendete Patterns
- **Observer Pattern**: Zur Einklinken in Import-Lifecycle Events
- **Repository Pattern**: Für abstrakte Datenschicht
- **Service Layer Pattern**: Geschäftslogik isoliert von Repositories
- **Factory Pattern**: Für Object-Erstellung
- **Strategy Pattern**: Verschiedene Link-Type Handling

### Datenfluss
```
Link CSV
    ↓
Parser (import-serializer)
    ↓
Converter (import-converter)
    ↓
Link Processor
    ├─→ ProductLinkRepository (Links speichern)
    └─→ ProductLinkAttributeRepository (Attribute speichern)
    ↓
Magento Database (catalog_product_link*)
```

## Abhängigkeiten

### Externe Pakete
- **Keine direkten PHP-Pakete**

### TechDivision Dependencies
- **import-product** ^26.2 - Base Product Importer (Parent)
- **import-converter** - Data Conversion Framework
- **import-serializer** - Data Serialization

### Abhängig von diesem Modul (2 Reverse Dependencies)
1. **import-product-grouped** - Grouped Product Importer (nutzt Links für Grouped)
2. **import-product-link-ee** - EE Link Extensions (EE Staging für Links)

## Wichtige Entry Points

### Repository Klassen
```php
// Product Link Repository - Haupt-Link-Verwaltung
ProductLinkRepository::create($row): void
ProductLinkRepository::findByProductId($productId, $linkTypeId): array
ProductLinkRepository::findByLinkedProductId($linkedId, $linkTypeId): array

// Product Link Attribute Repository - Attribute wie Qty
ProductLinkAttributeRepository::create($row): void
ProductLinkAttributeRepository::findByLinkId($linkId): array
```

### Service Methods
- `ProductLinkProcessor::process()` - Haupteingangspunkt
- `ProductLinkProcessor::validateLinks()` - Validierung vor Import
- `LinkTypeValidator::validate()` - Link Type Prüfung
- `LinkAssociationManager::createBidirectional()` - Bidirektionale Links

## Events & Extension Points

**Keine Custom Events** - Tier 5 Importer-Modul nutzt Parent-Events aus import-product

### Observer Hooks
- `product.import.link.validate.pre` - Vor Validierung
- `product.import.link.process.post` - Nach Link-Verarbeitung
- `product.import.link.attribute.process.post` - Nach Attribut-Verarbeitung
- `product.import.link.persist.error` - Bei Fehler

## Database Schema

### Relevante Tabellen
- **catalog_product_link** - Produkt-Relationen
  - `product_id` - Source Product
  - `linked_product_id` - Target Product
  - `link_type_id` - Type: 1=related, 2=upsell, 3=crosssell, 4=associated

- **catalog_product_link_attribute** - Attribute Definition
  - `link_type_id`
  - `product_link_attribute_code` - quantity, position

- **catalog_product_link_attribute_decimal** - Numerische Attribute (Qty)
  - `product_link_attribute_id`
  - `product_link_id`
  - `value` - Quantity

- **catalog_product_link_attribute_int** - Integer Attribute (Position)
  - `product_link_attribute_id`
  - `product_link_id`
  - `value` - Position Index

## Common Use Cases

### Use Case 1: Related Products
```php
// CSV Dateistruktur:
// sku,related_sku_1,related_qty_1,related_position_1

// PROD-001,PROD-002,1,1
// PROD-001,PROD-003,1,2
// Verarbeitung:
// 1. Validiere dass PROD-001, PROD-002, PROD-003 existieren
// 2. Erstelle Links in catalog_product_link (type=1)
// 3. Speichere Quantity und Position
```

### Use Case 2: Cross-Sell mit Mengen
```php
// CSV:
// sku,crosssell_sku,crosssell_qty

// SHIRT-001,SOCK-PACK,2
// Erstellt:
// 1. Link SHIRT-001 → SOCK-PACK (type=3, crosssell)
// 2. Quantity = 2
```

## Performance Considerations

### Wichtige Performance-Aspekte
1. **Link-Lookups**: Product IDs werden für beide Seiten nachgeschlagen
2. **Attribute-Inserts**: Separate Inserts für Qty und Position
3. **Bidirektional**: Manche Link-Types erfordern beide Richtungen
4. **Link-Type Indizes**: Queries oft gefiltert nach link_type_id

### Optimierungen
- Cache Product-IDs während Import
- Batch Insert für Links und Attribute (max 1000 pro Batch)
- Nutze Database Transactions für Konsistenz
- Pre-filter Productkombinationen um Duplikate zu vermeiden

## Hints für KI-Agenten

### Kritisches Verständnis
1. **Tier 5 Modul**: Spezialisierte Extension des Product Importers
2. **Link-fokussiert**: Arbeitet mit Produkt-Relationen
3. **Observer Pattern**: Integration mit Import-Pipeline durch Hooks
4. **Link Types**: 1=related, 2=upsell, 3=crosssell, 4=associated
5. **Bidirektional**: Manche Links erfordern beide Richtungen
6. **Basis-Modul**: Parent für Grouped und Link-EE

### Häufige Fehler
- ❌ Link-Type-IDs verwechseln (1 vs 3 vs 4)
- ❌ Bidirektionalität ignorieren
- ❌ Product-IDs nicht validieren
- ❌ Duplicate Links erstellen
- ❌ Position/Quantity nicht setzen
- ❌ Keine Transaktionen verwenden

### Best Practices
- ✅ Validiere dass beide Products existieren
- ✅ Nutze Repository für alle Operationen
- ✅ Setze sinnvolle Quantities und Positionen
- ✅ Nutze Transaktionen für Konsistenz
- ✅ Teste mit echten Link-CSV-Dateien
- ✅ Implementiere Duplicate-Detection

## Known Limitations

- **Product-Abhängig**: Beide Products müssen existieren
- **Link-Type-Limited**: Nur 4 Standard-Link-Types
- **Keine Bidirektional-Auto**: Bidirektionale Links müssen explizit importiert werden
- **Attribute-Fixed**: Nur Qty und Position als Standard-Attribute
- **No Versioning**: Keine nativen Versions/Audit-Trails

## Related Modules

### Direct Dependencies
- **import-product** - Base Product Importer (Parent)
- **import-converter** - Data Conversion Framework

### Modules Using This (2 Reverse Dependencies)
- **import-product-grouped** - Nutzt Links für Grouped Products
- **import-product-link-ee** - EE Extensions für Staging

### Related/Companion Modules
- **import-product-link-ee** - EE-spezifische Link Extensions
- **import-product-grouped** - Grouped Product Importer

## Troubleshooting

### Problem: Links werden nicht erstellt
**Mögliche Ursachen:**
1. Source oder Target Product existiert nicht
2. Link-Type-ID ist falsch
3. CSV-Format nicht korrekt

**Lösung:**
- Validiere dass beide Products existieren
- Prüfe dass link_type_id (1-4) korrekt ist
- Verwende korrektes CSV-Format

### Problem: Duplicates entstehen
**Mögliche Ursachen:**
1. Kein Duplicate-Check implementiert
2. Mehrfacher Import ohne Cleanup
3. CSV hat Duplicates

**Lösung:**
- Implementiere Duplicate-Detection
- Prüfe CSV auf Duplicates
- Nutze REPLACE statt INSERT

### Problem: Position/Quantity werden nicht übernommen
**Mögliche Ursachen:**
1. Attribute nicht gespeichert
2. Attribut-ID falsch
3. Werte sind NULL

**Lösung:**
- Validiere dass catalog_product_link_attribute_* gefüllt ist
- Prüfe dass product_link_attribute_id korrekt ist
- Stelle sicher dass Werte nicht NULL sind

## Zusammenfassung

`import-product-link` ist ein **Tier 5 Importer-Modul**, das spezialisierte Product Link Import-Funktionalität für Produkt-Relationen bereitstellt. Es ist das **Basis-Modul für 2 Extensions** (Grouped und Link-EE) und koordiniert komplexe bidirektionale Link-Zuordnungen.

**Für KI-Agenten:** Verstehe dieses Modul als:
- **Product Link Importer** mit Relation Management
- **Tier 5 Integration** als Basis für Grouped und EE
- **Link-Type-fokussiert** mit 4 Standard-Relationen
- **Bidirektional-Support** mit Attribut-Management
