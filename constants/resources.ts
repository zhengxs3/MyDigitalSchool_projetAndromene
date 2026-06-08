export type ResourceName =
  | "argent"
  | "informations"
  | "influence"
  | "cartesSabotage"
  | "shield";

export const RESOURCE_LIMITS = {
  argent: {
    label: "Argent",
    min: 100000,
    max: 500000,
    unit: "€",
  },
  informations: {
    label: "Informations",
    min: 1,
    max: 5,
    unit: "",
  },
  influence: {
    label: "Influence",
    min: 10,
    max: 100,
    unit: "",
  },
  cartesSabotage: {
    label: "Cartes Sabotage",
    min: 0,
    max: 3,
    unit: "",
  },
  shield: {
    label: "Shield",
    min: 0,
    max: 1,
    unit: "",
  },
};

function randomBetween(min: number, max: number) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

export function generateResources() {
  return {
    argent: randomBetween(
      RESOURCE_LIMITS.argent.min,
      RESOURCE_LIMITS.argent.max
    ),
    informations: randomBetween(
      RESOURCE_LIMITS.informations.min,
      RESOURCE_LIMITS.informations.max
    ),
    influence: randomBetween(
      RESOURCE_LIMITS.influence.min,
      RESOURCE_LIMITS.influence.max
    ),
    cartesSabotage: randomBetween(
      RESOURCE_LIMITS.cartesSabotage.min,
      RESOURCE_LIMITS.cartesSabotage.max
    ),
    shield: randomBetween(
      RESOURCE_LIMITS.shield.min,
      RESOURCE_LIMITS.shield.max
    ),
  };
}