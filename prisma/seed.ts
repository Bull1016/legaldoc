// prisma/seed.ts
import { PrismaClient, RequiredRole } from "@prisma/client";
import bcrypt from "bcryptjs";

const prisma = new PrismaClient();

async function main() {
  console.log("🌱 Démarrage du seed...");

  // --- Créer l'admin ---
  const adminEmail = process.env.ADMIN_EMAIL || "admin@legaldoc.fr";
  const adminPassword = process.env.ADMIN_PASSWORD || "Admin@LegalDoc2026!";

  const existingAdmin = await prisma.user.findUnique({
    where: { email: adminEmail },
  });

  if (!existingAdmin) {
    const hash = await bcrypt.hash(adminPassword, 12);
    await prisma.user.create({
      data: {
        email: adminEmail,
        passwordHash: hash,
        fullName: "Administrateur LegalDoc",
        role: "admin",
      },
    });
    console.log(`✅ Admin créé : ${adminEmail}`);
  } else {
    console.log(`ℹ️  Admin déjà existant : ${adminEmail}`);
  }

  // --- Créer un juriste de démonstration ---
  const juristeEmail = "juriste@legaldoc.fr";
  const existingJuriste = await prisma.user.findUnique({
    where: { email: juristeEmail },
  });

  if (!existingJuriste) {
    const hash = await bcrypt.hash("Juriste@LegalDoc2026!", 12);
    await prisma.user.create({
      data: {
        email: juristeEmail,
        passwordHash: hash,
        fullName: "Maître Sophie Bernard",
        role: "juriste",
        phone: "+33 1 23 45 67 89",
      },
    });
    console.log(`✅ Juriste créé : ${juristeEmail}`);
  }

  // --- Créer les services ---
  const services = [
    {
      name: "Création de SARL",
      description:
        "Créez votre Société à Responsabilité Limitée rapidement et simplement. Nos juristes rédigent vos statuts et effectuent toutes les formalités d'immatriculation au RCS.",
      category: "Entreprise",
      basePrice: 299.0,
      icon: "Building2",
      requiredRole: RequiredRole.juriste,
      formSchema: {
        steps: [
          {
            title: "Informations sur la société",
            fields: [
              {
                id: "company_name",
                label: "Dénomination sociale",
                type: "text",
                required: true,
                placeholder: "Ex: Ma Société SARL",
              },
              {
                id: "activity",
                label: "Objet social (activité)",
                type: "textarea",
                required: true,
                placeholder: "Décrivez l'activité de la société...",
              },
              {
                id: "capital",
                label: "Capital social (€)",
                type: "number",
                required: true,
                placeholder: "1000",
              },
              {
                id: "siege_social",
                label: "Adresse du siège social",
                type: "text",
                required: true,
                placeholder: "123 rue de la Paix, 75001 Paris",
              },
            ],
          },
          {
            title: "Gérant(s)",
            fields: [
              {
                id: "gerant_name",
                label: "Nom et prénom du gérant",
                type: "text",
                required: true,
              },
              {
                id: "gerant_dob",
                label: "Date de naissance du gérant",
                type: "date",
                required: true,
              },
              {
                id: "gerant_address",
                label: "Adresse personnelle du gérant",
                type: "text",
                required: true,
              },
            ],
          },
          {
            title: "Associés",
            fields: [
              {
                id: "associes_count",
                label: "Nombre d'associés",
                type: "number",
                required: true,
                placeholder: "2",
              },
              {
                id: "associes_details",
                label: "Détails des associés (nom, parts)",
                type: "textarea",
                required: true,
                placeholder: "Associé 1 : Jean Dupont - 50 parts\nAssocié 2 : Marie Martin - 50 parts",
              },
            ],
          },
        ],
        requiredDocuments: [
          "Pièce d'identité du gérant (recto-verso)",
          "Justificatif de domicile du siège social (< 3 mois)",
          "Attestation de domicile personnel du gérant",
        ],
      },
    },
    {
      name: "Création de SAS",
      description:
        "Créez votre Société par Actions Simplifiée avec des statuts sur-mesure adaptés à vos besoins. Idéal pour les startups et les projets avec investisseurs.",
      category: "Entreprise",
      basePrice: 399.0,
      icon: "Rocket",
      requiredRole: RequiredRole.juriste,
      formSchema: {
        steps: [
          {
            title: "Informations sur la société",
            fields: [
              {
                id: "company_name",
                label: "Dénomination sociale",
                type: "text",
                required: true,
                placeholder: "Ex: Ma StartUp SAS",
              },
              {
                id: "activity",
                label: "Objet social",
                type: "textarea",
                required: true,
              },
              {
                id: "capital",
                label: "Capital social (€)",
                type: "number",
                required: true,
              },
              {
                id: "siege_social",
                label: "Adresse du siège social",
                type: "text",
                required: true,
              },
            ],
          },
          {
            title: "Président",
            fields: [
              {
                id: "president_name",
                label: "Nom et prénom du président",
                type: "text",
                required: true,
              },
              {
                id: "president_type",
                label: "Le président est",
                type: "select",
                required: true,
                options: ["Une personne physique", "Une personne morale (société)"],
              },
            ],
          },
        ],
        requiredDocuments: [
          "Pièce d'identité du président",
          "Justificatif de domicile du siège social",
        ],
      },
    },
    {
      name: "Contrat de travail",
      description:
        "Obtenez un contrat de travail conforme à la législation française. CDI, CDD, temps partiel — nos experts rédigent un contrat adapté à votre situation.",
      category: "Contrats",
      basePrice: 149.0,
      icon: "FileText",
      requiredRole: RequiredRole.juriste,
      formSchema: {
        steps: [
          {
            title: "Type de contrat",
            fields: [
              {
                id: "contract_type",
                label: "Type de contrat",
                type: "select",
                required: true,
                options: ["CDI", "CDD", "Temps partiel CDI", "Temps partiel CDD"],
              },
              {
                id: "convention_collective",
                label: "Convention collective applicable",
                type: "text",
                required: false,
                placeholder: "Ex: Commerce de détail non alimentaire",
              },
            ],
          },
          {
            title: "Informations employeur & salarié",
            fields: [
              {
                id: "employer_name",
                label: "Raison sociale de l'employeur",
                type: "text",
                required: true,
              },
              {
                id: "employee_name",
                label: "Nom et prénom du salarié",
                type: "text",
                required: true,
              },
              {
                id: "poste",
                label: "Intitulé du poste",
                type: "text",
                required: true,
              },
              {
                id: "salary",
                label: "Salaire brut mensuel (€)",
                type: "number",
                required: true,
              },
              {
                id: "start_date",
                label: "Date de début",
                type: "date",
                required: true,
              },
            ],
          },
        ],
        requiredDocuments: ["Aucun document requis pour ce service"],
      },
    },
    {
      name: "Dépôt de marque",
      description:
        "Protégez votre marque, votre logo ou votre slogan auprès de l'INPI. Nos experts en propriété intellectuelle gèrent toute la procédure.",
      category: "Protection",
      basePrice: 249.0,
      icon: "Shield",
      requiredRole: RequiredRole.juriste,
      formSchema: {
        steps: [
          {
            title: "Informations sur la marque",
            fields: [
              {
                id: "brand_name",
                label: "Nom de la marque",
                type: "text",
                required: true,
              },
              {
                id: "brand_type",
                label: "Type de marque",
                type: "select",
                required: true,
                options: [
                  "Marque verbale (nom)",
                  "Marque figurative (logo)",
                  "Marque semi-figurative (nom + logo)",
                ],
              },
              {
                id: "classes",
                label: "Classes Nice (secteurs d'activité)",
                type: "textarea",
                required: true,
                placeholder: "Décrivez vos produits/services pour identifier les classes...",
              },
            ],
          },
          {
            title: "Titulaire",
            fields: [
              {
                id: "owner_type",
                label: "Vous êtes",
                type: "select",
                required: true,
                options: ["Un particulier", "Une société"],
              },
              {
                id: "owner_name",
                label: "Nom ou raison sociale",
                type: "text",
                required: true,
              },
            ],
          },
        ],
        requiredDocuments: [
          "Représentation de la marque (si logo)",
          "Pièce d'identité ou Kbis",
        ],
      },
    },
    {
      name: "Modification de statuts",
      description:
        "Changement de dénomination, de siège social, d'objet ou augmentation de capital — nos juristes gèrent toutes vos modifications statutaires.",
      category: "Entreprise",
      basePrice: 199.0,
      icon: "Edit",
      requiredRole: RequiredRole.juriste,
      formSchema: {
        steps: [
          {
            title: "Informations sur la société",
            fields: [
              {
                id: "company_name",
                label: "Nom actuel de la société",
                type: "text",
                required: true,
              },
              {
                id: "siren",
                label: "Numéro SIREN",
                type: "text",
                required: true,
                placeholder: "123 456 789",
              },
              {
                id: "modification_type",
                label: "Type de modification",
                type: "select",
                required: true,
                options: [
                  "Changement de dénomination",
                  "Transfert de siège social",
                  "Changement d'objet social",
                  "Augmentation de capital",
                  "Réduction de capital",
                  "Autre",
                ],
              },
              {
                id: "details",
                label: "Détails de la modification",
                type: "textarea",
                required: true,
              },
            ],
          },
        ],
        requiredDocuments: [
          "Statuts actuels de la société",
          "Kbis de moins de 3 mois",
          "PV de décision de modification",
        ],
      },
    },
    {
      name: "Dissolution de société",
      description:
        "Clôturez votre société dans les règles. Nos experts gèrent la dissolution-liquidation amiable de votre entreprise de A à Z.",
      category: "Entreprise",
      basePrice: 349.0,
      icon: "X",
      requiredRole: RequiredRole.juriste,
      formSchema: {
        steps: [
          {
            title: "Informations sur la société",
            fields: [
              {
                id: "company_name",
                label: "Nom de la société",
                type: "text",
                required: true,
              },
              {
                id: "siren",
                label: "Numéro SIREN",
                type: "text",
                required: true,
              },
              {
                id: "company_type",
                label: "Forme juridique",
                type: "select",
                required: true,
                options: ["SARL", "SAS", "EURL", "SASU", "SA", "Autre"],
              },
              {
                id: "reason",
                label: "Motif de dissolution",
                type: "textarea",
                required: true,
              },
            ],
          },
        ],
        requiredDocuments: [
          "Kbis de moins de 3 mois",
          "Statuts à jour",
          "PV de décision de dissolution",
          "Bilan de clôture",
        ],
      },
    },
  ];

  for (const service of services) {
    const existing = await prisma.service.findFirst({
      where: { name: service.name },
    });
    if (!existing) {
      await prisma.service.create({ data: service });
      console.log(`✅ Service créé : ${service.name}`);
    } else {
      console.log(`ℹ️  Service déjà existant : ${service.name}`);
    }
  }

  console.log("\n🎉 Seed terminé avec succès !");
  console.log(`\n📧 Compte admin : ${adminEmail}`);
  console.log(`🔑 Mot de passe admin : ${process.env.ADMIN_PASSWORD || "Admin@LegalDoc2026!"}`);
  console.log(`\n📧 Compte juriste : juriste@legaldoc.fr`);
  console.log(`🔑 Mot de passe juriste : Juriste@LegalDoc2026!`);
}

main()
  .catch((e) => {
    console.error("❌ Erreur lors du seed:", e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
  